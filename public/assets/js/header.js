// header.js – загружает шапку и обновляет навигацию
(function() {
  const container = document.getElementById('header-container');
  if (!container) return;

  fetch('/components/header.html')
    .then(r => r.text())
    .then(html => {
      container.innerHTML = html;
      updateNav();
    });

  function updateNav() {
    const token = localStorage.getItem('token');
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const guestLinks = document.getElementById('guestLinks');
    const userLinks = document.getElementById('userLinks');
    const adminLink = document.getElementById('adminLink');

    if (token) {
      if (guestLinks) guestLinks.style.display = 'none';
      if (userLinks) userLinks.style.display = 'flex';
      if (adminLink && user.role === 'admin') adminLink.style.display = 'block';
    } else {
      if (guestLinks) guestLinks.style.display = 'flex';
      if (userLinks) userLinks.style.display = 'none';
      if (adminLink) adminLink.style.display = 'none';
    }
  }
})();