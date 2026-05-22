// resources/js/modal.js
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('authOverlay');
    const modal = document.getElementById('authModal');
    
    // Кнопки закрытия (проверяем оба варианта ID из твоих файлов)
    const closeBtn = document.getElementById('authModalClose') || document.getElementById('modalClose');
    
    const loginBtn = document.querySelector('.header-btns .login');
    
    // Элементы переключения форм внутри модалки
    const showLoginFormLink = document.getElementById('showLoginForm');
    const showRegFormLink = document.getElementById('showRegForm');
    const regFormContainer = document.getElementById('regFormContainer');
    const loginFormContainer = document.getElementById('loginFormContainer');

    function openModal() {
        if (overlay) overlay.style.display = 'block';
        if (modal) modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // блокируем прокрутку фона
    }

    function closeModal() {
        if (overlay) overlay.style.display = 'none';
        if (modal) modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Открытие по клику на "Войти" в шапке
    if (loginBtn) loginBtn.addEventListener('click', (e) => { e.preventDefault(); openModal(); });
    
    // 🔹 Открытие по клику на любую кнопку с классом .auth-guard (для гостей)
    document.querySelectorAll('.auth-guard').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    // Закрытие по Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.style.display !== 'none') closeModal();
    });

    // 🔹 Реальное переключение между Входом и Регистрацией внутри модалки
    if (showLoginFormLink) {
        showLoginFormLink.addEventListener('click', (e) => {
            e.preventDefault();
            regFormContainer.style.display = 'none';
            loginFormContainer.style.display = 'block';
        });
    }

    if (showRegFormLink) {
        showRegFormLink.addEventListener('click', (e) => {
            e.preventDefault();
            loginFormContainer.style.display = 'none';
            regFormContainer.style.display = 'block';
        });
    }

    // Маска для паспорта
    const passportInput = document.getElementById('passport');
    if (passportInput) {
        passportInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }
});