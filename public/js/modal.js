/**
 * modal.js — Авторизация и переключение форм
 */
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('authOverlay');
    const modal = document.getElementById('authModal');
    const closeBtn = document.getElementById('modalClose');
    const loginBtn = document.querySelector('.header-btns .login');

    const regContainer = document.getElementById('regFormContainer');
    const loginContainer = document.getElementById('loginFormContainer');
    const showLoginLink = document.getElementById('showLoginForm');
    const showRegLink = document.getElementById('showRegForm');

    if (!modal || !overlay) {
        console.log('❌ Модалка не найдена');
        return;
    }

    console.log('✅ modal.js загружен');

    // === Открытие модалки ===
    function openModal() {
        console.log('🔓 Открытие модалки');
        overlay.style.display = 'block';
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Показываем форму регистрации по умолчанию
        if (regContainer && loginContainer) {
            regContainer.style.display = 'block';
            loginContainer.style.display = 'none';
        }
    }

    // === Закрытие модалки ===
    function closeModal() {
        console.log('🔒 Закрытие модалки');
        overlay.style.display = 'none';
        modal.style.display = 'none';
        document.body.style.overflow = '';

        // Очищаем поля
        document.querySelectorAll('#authModal input').forEach(input => {
            input.value = '';
        });
    }

    // === Переключение на форму ВХОДА ===
    function showLoginForm(e) {
        if (e) e.preventDefault();
        console.log('🔄 Переключение на ВХОД');

        if (regContainer && loginContainer) {
            regContainer.style.display = 'none';
            loginContainer.style.display = 'block';
        }
    }

    // === Переключение на форму РЕГИСТРАЦИИ ===
    function showRegForm(e) {
        if (e) e.preventDefault();
        console.log('🔄 Переключение на РЕГИСТРАЦИЮ');

        if (loginContainer && regContainer) {
            loginContainer.style.display = 'none';
            regContainer.style.display = 'block';
        }
    }

    // === Вешаем обработчики событий ===

    // Кнопка "Войти" в шапке
    if (loginBtn) {
        loginBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
        console.log('✅ Кнопка "Войти" найдена');
    } else {
        console.log('⚠️ Кнопка "Войти" не найдена (возможно, пользователь авторизован)');
    }

    // Крестик закрытия
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Клик по оверлею
    overlay.addEventListener('click', closeModal);

    // Клавиша Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });

    // 🔹 Ссылка "Войти" внутри модалки (переключение на форму входа)
    if (showLoginLink) {
        showLoginLink.addEventListener('click', showLoginForm);
        console.log('✅ Ссылка "showLoginForm" найдена');
    } else {
        console.error('❌ Ссылка "showLoginForm" НЕ найдена!');
    }

    // 🔹 Ссылка "Зарегистрироваться" внутри модалки (переключение на регистрацию)
    if (showRegLink) {
        showRegLink.addEventListener('click', showRegForm);
        console.log('✅ Ссылка "showRegForm" найдена');
    } else {
        console.error('❌ Ссылка "showRegForm" НЕ найдена!');
    }

    // === Маска для паспорта (только цифры) ===
    const passportInput = document.getElementById('passport');
    if (passportInput) {
        passportInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }

    // === Вспомогательная функция показа ошибок ===
    function showErrors(form, errors) {
        // Удаляем старые ошибки
        form.querySelectorAll('.error-msg').forEach(el => el.remove());
        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        // Показываем новые
        Object.entries(errors).forEach(([field, messages]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('input-error');
                messages.forEach(msg => {
                    const err = document.createElement('div');
                    err.className = 'error-msg';
                    err.style.cssText = 'color: #dc2626; font-size: 12px; margin-top: 4px;';
                    err.textContent = msg;
                    input.closest('.form-group')?.appendChild(err);
                });
            }
        });
    }

    // === Обработка формы РЕГИСТРАЦИИ ===
    const regForm = document.getElementById('regForm');
    if (regForm) {
        regForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            console.log('📤 Отправка регистрации...');

            const submitBtn = regForm.querySelector('.btn-submit');
            const originalText = submitBtn?.textContent || 'Зарегистрироваться';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Регистрация...';
            }

            // Очищаем старые ошибки
            regForm.querySelectorAll('.error-msg').forEach(el => el.remove());
            regForm.querySelectorAll('input').forEach(i => i.classList.remove('input-error'));

            try {
                const response = await fetch(regForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(regForm),
                });

                console.log('📡 Ответ сервера:', response.status);
                const data = await response.json();
                console.log('📄 Данные:', data);

                if (!response.ok) {
                    if (data.errors) {
                        showErrors(regForm, data.errors);
                    } else {
                        alert(data.message || 'Ошибка регистрации');
                    }
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                    return;
                }

                // Успех!
                alert(data.message || 'Регистрация успешна!');
                closeModal();

                // Перенаправление
                const redirectUrl = localStorage.getItem('authRedirect');
                if (redirectUrl) {
                    localStorage.removeItem('authRedirect');
                    window.location.href = redirectUrl;
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.reload();
                }

            } catch (error) {
                console.error('💥 Ошибка:', error);
                alert('Произошла ошибка. Проверьте консоль.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            }
        });
        console.log('✅ Форма регистрации найдена');
    }

    // === Обработка формы ВХОДА ===
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            console.log('📤 Отправка входа...');

            const submitBtn = loginForm.querySelector('.btn-submit');
            const originalText = submitBtn?.textContent || 'Войти';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Вход...';
            }

            // Очищаем старые ошибки
            loginForm.querySelectorAll('.error-msg').forEach(el => el.remove());
            loginForm.querySelectorAll('input').forEach(i => i.classList.remove('input-error'));

            try {
                const response = await fetch(loginForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(loginForm),
                });

                console.log('📡 Ответ сервера:', response.status);
                const data = await response.json();
                console.log('📄 Данные:', data);

                if (!response.ok) {
                    if (data.errors) {
                        showErrors(loginForm, data.errors);
                    } else {
                        alert(data.message || 'Ошибка входа');
                    }
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                    return;
                }

                // Успех!
                alert(data.message || 'Вход выполнен!');
                closeModal();

                // Перенаправление
                const redirectUrl = localStorage.getItem('authRedirect');
                if (redirectUrl) {
                    localStorage.removeItem('authRedirect');
                    window.location.href = redirectUrl;
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.reload();
                }

            } catch (error) {
                console.error('💥 Ошибка:', error);
                alert('Произошла ошибка. Проверьте консоль.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            }
        });
        console.log('✅ Форма входа найдена');
    }
});