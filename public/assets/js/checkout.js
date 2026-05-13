// Получение ID тарифа из URL
const urlParams = new URLSearchParams(window.location.search);
const tariffId = urlParams.get('tariff');

// Загрузка информации о тарифе
async function loadTariffInfo() {
    if (!tariffId) {
        window.location.href = 'tariffs.html';
        return;
    }
    
    try {
        const response = await fetch(`/api/tariffs/${tariffId}`);
        const tariff = await response.json();
        
        // Отображение выбранного тарифа
        document.getElementById('selectedTariff').innerHTML = `
            <h3>${tariff.name}</h3>
            <p>${tariff.description}</p>
        `;
        document.getElementById('tariffName').textContent = tariff.name;
        document.getElementById('tariffPrice').textContent = `${tariff.price} ₽`;
        document.getElementById('totalPrice').textContent = `${tariff.price} ₽`;
    } catch (error) {
        console.error('Ошибка загрузки тарифа:', error);
    }
}

// Переключение способов оплаты
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const cardFields = document.getElementById('cardFields');
        if (this.value === 'card') {
            cardFields.style.display = 'block';
        } else {
            cardFields.style.display = 'none';
        }
    });
});

// Маска для номера карты
document.querySelector('[name="card_number"]')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{4})/g, '$1 ').trim();
    e.target.value = value.substring(0, 19);
});

// Маска для срока действия
document.querySelector('[name="card_expiry"]')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2);
    }
    e.target.value = value.substring(0, 5);
});

// Отправка формы
document.getElementById('checkoutForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Обработка...';
    
    try {
        // Имитация оплаты
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Создание заказа
        const token = localStorage.getItem('token');
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                tariff_id: tariffId,
                payment_method: document.querySelector('input[name="payment_method"]:checked').value
            })
        });
        
        if (response.ok) {
            const order = await response.json();
            showNotification('Оплата успешна! Подписка активирована.', 'success');
            setTimeout(() => {
                window.location.href = `subscriptions.html`;
            }, 1500);
        } else {
            throw new Error('Ошибка создания заказа');
        }
    } catch (error) {
        showNotification('Ошибка при оплате. Попробуйте снова.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Оплатить';
    }
});

// Загрузка при инициализации
if (tariffId) {
    loadTariffInfo();
}