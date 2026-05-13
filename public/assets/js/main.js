import { api } from './api.js';

// Проверить, авторизован ли пользователь
function isLoggedIn() {
  return !!localStorage.getItem('token');
}

// Обновить навигацию
function updateNav() {
  const guestBlock = document.getElementById('guestLinks');
  const userBlock = document.getElementById('userLinks');
  const adminLink = document.getElementById('adminLink');

  if (isLoggedIn()) {
    if (guestBlock) guestBlock.style.display = 'none';
    if (userBlock) userBlock.style.display = 'flex';

    // Проверка роли администратора (можно загрузить из профиля)
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    if (user.role === 'admin' && adminLink) {
      adminLink.style.display = 'block';
    }
  } else {
    if (guestBlock) guestBlock.style.display = 'flex';
    if (userBlock) userBlock.style.display = 'none';
    if (adminLink) adminLink.style.display = 'none';
  }
}

// Выход
window.logout = function() {
  localStorage.removeItem('token');
  localStorage.removeItem('user');
  window.location.href = '/login.html';
};

// Загрузка компонентов (header/footer)
async function loadComponent(id, url) {
  const el = document.getElementById(id);
  if (!el) return;
  const resp = await fetch(url);
  const html = await resp.text();
  el.innerHTML = html;
  updateNav();
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
  loadComponent('header-container', '/components/header.html');
  loadComponent('footer-container', '/components/footer.html');
  updateNav();
});