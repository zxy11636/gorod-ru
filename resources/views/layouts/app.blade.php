<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Город.ру - @yield('title', 'Платформа городских инициатив')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/modal.js') }}" defer></script>
    <script src="{{ asset('js/theme.js') }}" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('scripts')
</head>
<script>
    (function() {
        var t = localStorage.getItem('theme');
        var p = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (t === 'dark' || (!t && p)) document.documentElement.classList.add('dark');
    })();
</script>

<body class="{{ auth()->check() ? 'authed' : '' }}">
    <header>
        <div class="container">
            <div class="header_inner">
                <div class="logo">
                    <a href="{{ route('home') }}" class="logo-link">
                        <img src="{{ asset('images/Logo.svg') }}" alt="Логотип Город.ру">
                        <p>Город.ру</p>
                    </a>
                </div>

                <button class="mobile-menu-toggle md:hidden" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>


                {{-- 🔹 Навигация: только для авторизованных --}}
                @auth
                <ul class="header_nav">
                    <li class="header_nav-item">
                        <a href="{{ route('projects.index') }}">Проекты</a>
                    </li>
                    <li class="header_nav-item"><a href="{{ route('how-it-works') }}">Как это работает?</a></li>
                </ul>
                @endauth

                <div class="header-btns">
                    @guest
                    {{-- Только для гостей: кнопка Войти --}}
                    <button class="login" id="openLoginBtn">Войти</button>
                    @endguest

                    @auth
                    @if(request()->routeIs('profile.edit'))
                    <form action="{{ url('/logout') }}" method="POST" class="header-logout-form">
                        @csrf
                        <button type="submit" class="header-logout-btn" title="Выйти из аккаунта">
                            <img src="{{ asset('images/logout.svg') }}" alt="Выйти" class="header-icon">
                        </button>
                    </form>
                    @else
                    <a href="{{ route('profile.edit') }}" class="profile-link" title="Мой профиль">
                        <img src="{{ asset('images/profil.svg') }}" alt="Профиль" class="header-icon">
                    </a>
                    @endif
                    <!-- Кнопка переключения темы -->
                    <button id="themeToggle" class="theme-toggle" title="Переключить тему">
                        <svg class="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        <svg class="moon-icon hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>
                    @endauth
                </div>
            </div>

            {{-- Мобильное меню --}}
            <div class="mobile-menu" id="mobileMenu">
                @auth
                <ul class="mobile-nav">
                    <li class="mobile-nav-item">
                        <a href="{{ route('projects.index') }}">Проекты</a>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="{{ route('how-it-works') }}">Как это работает?</a>
                    </li>
                </ul>
                @endauth

                <div class="mobile-menu-footer">

                    @guest
                    <button class="login mobile-login" id="openLoginBtnMobile">
                        Войти
                    </button>
                    @endguest

                    @auth

                    <a href="{{ route('profile.edit') }}" class="mobile-profile-link">
                        Мой профиль
                    </a>

                    <form action="{{ url('/logout') }}" method="POST" class="mobile-logout-form">
                        @csrf
                        <button type="submit" class="mobile-logout-btn">
                            Выйти из аккаунта
                        </button>
                    </form>

                    @endauth

                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>

        <div class="container">

            <div class="footer_inner">

                <!-- BRAND -->
                <div class="footer-brand">
                    <ul class="footer-item">

                        <li class="footer_logo-item">
                            <img src="{{ asset('images/Footer-logo.svg') }}" alt="">
                            <p>Город.ру</p>
                        </li>

                        <li class="footer_logo_text">
                            Платформа для совместного изменения городов к лучшему.
                            Предлагайте идеи, поддерживайте инициативы
                            и делайте свой город современнее.
                        </li>

                        <li class="footer-socials">

                            <a href="https://t.me/" target="_blank">
                                <img src="{{ asset('images/tg.svg') }}" alt="">
                            </a>

                            <a href="https://vk.com/" target="_blank">
                                <img src="{{ asset('images/vk.svg') }}" alt="">
                            </a>

                        </li>

                    </ul>
                </div>

                <!-- NAV -->
                <ul class="footer-item">
                    <li class="footer-title">Навигация</li>

                    <li class="footer-links">
                        <a href="{{ route('projects.index') }}">Проекты</a>
                    </li>

                    <li class="footer-links">
                        <a href="{{ route('how-it-works') }}">Как это работает</a>
                    </li>
                </ul>

                <!-- CITY -->
                <ul class="footer-item">
                    <li class="footer-title">Для города</li>

                    <li class="footer-links">
                        <a href="#">Для администрации</a>
                    </li>

                    <li class="footer-links">
                        <a href="#">Партнёрство</a>
                    </li>
                </ul>

                <!-- CONTACT -->
                <ul class="footer-item">
                    <li class="footer-title">Контакты</li>

                    <li class="footer-contact">
                        hello@gorod.ru
                    </li>

                    <li class="footer-contact">
                        8 800 555-35-35
                    </li>

                    <li class="footer-contact">
                        Москва, ул. Городская, 1
                    </li>
                </ul>

            </div>

        </div>

        <!-- UNDERFOOTER -->

        <div class="underfooter">

            <div class="container">

                <div class="underfooter_inner">

                    <div class="underfooter_left">
                        © {{ date('Y') }} Город.ру — Все права защищены
                    </div>

                    <div class="underfooter_links">

                        <a href="#">
                            Пользовательское соглашение
                        </a>

                        <a href="#">
                            Политика конфиденциальности
                        </a>

                        <a href="#">
                            Публичная оферта
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </footer>

    <div class="overlay" id="authOverlay" style="display: none;"></div>

    <div class="modal" id="authModal" style="display: none;">
        <div class="modal__image">
            <div class="modal__image-content">
                <h3 class="modal__image-title">
                    Меняйте<br>
                    свой город
                </h3>

                <p class="modal__image-text">
                    Поддерживайте инициативы, создавайте проекты
                    и участвуйте в развитии городской среды.
                </p>
            </div>
        </div>

        <div class="modal__form">
            <button class="modal__close" id="modalClose">&times;</button>

            <div id="regFormContainer">
                <h2 class="modal__title">Регистрация</h2>
                <form id="regForm" autocomplete="off" method="POST" action="{{ route('ajax.register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="passport">Серия и номер паспорта</label>
                        <input type="text" id="passport" name="passport" placeholder="000000 0000" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="email">Почта</label>
                        <input type="email" id="email" name="email" placeholder="пример@почты.ру" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label for="passwordConfirm">Повторите пароль</label>
                        <input type="password" id="passwordConfirm" name="password_confirmation" placeholder="••••••••" required>
                    </div>

                    <!-- 🔹 ВЫБОР РОЛИ (Добавили этот блок) -->
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px;">Кто вы на платформе?</label>
                        <div class="role-selection" style="display: flex; gap: 15px; margin-bottom: 15px;">
                            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px;">
                                <input type="radio" name="role" value="donor" checked style="cursor: pointer;">
                                <span>Донатер (поддерживаю проекты)</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px;">
                                <input type="radio" name="role" value="author" style="cursor: pointer;">
                                <span>Автор (создаю проекты)</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Зарегистрироваться</button>
                </form>
                <p class="login-link">Уже есть аккаунт? <a href="#" id="showLoginForm">Войти</a></p>
            </div>

            <div id="loginFormContainer" style="display: none;">
                <h2 class="modal__title">Вход</h2>
                <form id="loginForm" autocomplete="off" method="POST" action="{{ route('ajax.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="login_email">Почта</label>
                        <input type="email" id="login_email" name="email" placeholder="пример@почты.ру" required>
                    </div>
                    <div class="form-group">
                        <label for="login_password">Пароль</label>
                        <input type="password" id="login_password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-submit">Войти</button>
                </form>
                <p class="login-link">Нет аккаунта? <a href="#" id="showRegForm">Зарегистрироваться</a></p>
            </div>

        </div>
    </div>

    <div class="modal" id="createProjectModal" style="display: none; flex-direction: column;">
        <div class="modal__form" style="width: 100%; padding: 40px;">
            <button type="button" class="modal__close" onclick="closeModal('createProjectModal')">&times;</button>
            <h2 class="modal__title">Предложить проект</h2>

            <form id="createProjectForm" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="pending">

                <div class="form-group">
                    <label>Название проекта</label>
                    <input type="text" name="title" required placeholder="Например: Парк у дома">
                </div>

                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" required placeholder="Кратко опишите суть проекта..." rows="4"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Целевая сумма (₽)</label>
                        <input type="number" name="goal_amount" required placeholder="100000">
                    </div>
                    <div class="form-group">
                        <label>Категория</label>
                        <input type="text" name="category" placeholder="parks">
                    </div>
                </div>

                <div class="form-group">
                    <label>Район</label>
                    <input type="text" name="district" required placeholder="Например: Центральный">
                </div>


                <div class="form-group">
                    <label>Обложка проекта</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <button type="submit" class="btn-submit">Отправить на модерацию</button>
            </form>
        </div>
    </div>


    <script src="{{ asset('js/projects-slider.js') }}"></script>
    {{-- 🔹 Анимации при скролле (Главная страница) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🔹 Intersection Observer для анимаций при скролле
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 // Элемент появится, когда 15% его видно
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        // Опционально: перестать наблюдать после появления
                        // observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // 🔹 Наблюдаем за всеми элементами с классом animate-on-scroll
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });

            // 🔹 Отдельно для карточек проектов (чтобы анимировать прогресс-бары)
            document.querySelectorAll('.feat-card, .project-card, .completed-card, .step-card').forEach(el => {
                observer.observe(el);
            });

            // 🔹 Hero-секция: анимация при загрузке (без скролла)
            const hero = document.querySelector('.hero');
            if (hero) {
                hero.classList.add('is-loaded');
            }

            // 🔹 Плавная прокрутка для якорных ссылок
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // 🔹 Мобильное меню
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const headerInner = document.querySelector('.header_inner');
            const body = document.body;

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    mobileMenuToggle.classList.toggle('active');
                    headerInner.classList.toggle('mobile-menu-open');
                    body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
                });

                // Закрытие меню при клике на ссылку
                document.querySelectorAll('.mobile-nav a, .mobile-profile-link').forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('active');
                        mobileMenuToggle.classList.remove('active');
                        headerInner.classList.remove('mobile-menu-open');
                        body.style.overflow = '';
                    });
                });
            }

            // 🔹 Мобильная кнопка входа
            const mobileLoginBtn = document.getElementById('openLoginBtnMobile');
            if (mobileLoginBtn) {
                mobileLoginBtn.addEventListener('click', function() {
                    document.getElementById('authOverlay').style.display = 'block';
                    document.getElementById('authModal').style.display = 'flex';
                    mobileMenu.classList.remove('active');
                    mobileMenuToggle.classList.remove('active');
                    headerInner.classList.remove('mobile-menu-open');
                    body.style.overflow = '';
                });
            }

        });
    </script>
</body>

</html>