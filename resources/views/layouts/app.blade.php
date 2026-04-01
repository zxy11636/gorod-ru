<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Город.ру - @yield('title', 'Платформа городских инициатив')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <div class="header_inner">
                <div class="logo">
                    <img src="{{ asset('images/Logo.svg') }}" alt="Логотип Город.ру">
                    <p>Город.ру</p>
                </div>
                <ul class="header_nav">
                    <li class="header_nav-item"><a href="{{ route('projects.index') }}">Проекты</a></li>
                    <li class="header_nav-item"><a href="{{ route('map') }}">Карта</a></li>
                    <li class="header_nav-item"><a href="{{ route('how-it-works') }}">Как это работает?</a></li>
                </ul>
                <div class="header-btns">
                    <button class="offer">Предложить +</button>
                    <button class="login">Войти</button>
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
                <div class="footer_logo">
                <ul class="footer-item">
                    <li class="footer_logo-item"><img src="{{ asset('images/Footer-logo.svg') }}" alt="Логотип Город.ру"> <p>Город.ру</p></li>
                    <li class="footer_logo_text">Платформа для совместного <br> 
                    изменения городов к лучшему</li>
                </ul>
                </div>
                <ul class="footer-item">
                    <li class="footer-title">НАВИГАЦИЯ</li>
                    <li class="footer-links"><a href="">Проекты</a></li>
                    <li class="footer-links"><a href="">Карта</a></li>
                    <li class="footer-links"><a href="">Как это работает</a></li>
                    <li class="footer-links"><a href="">Блог</a></li>
                    <li class="footer-links"><a href="">О нас</a></li>
                    </ul>
                <ul class="footer-item">
                    <li class="footer-title">ДЛЯ ГОРОДА</li>
                    <li class="footer-links"><a href="">Для администрации</a></li>
                    <li class="footer-links"><a href="">Партнерство</a></li>
                    <li class="footer-links"><a href="">Пресса</a></li>
                    <li class="footer-links"><a href="">Вакансии</a></li>
                    </ul>
                <ul class="footer-item">
                    <li class="footer-title">СВЯЖИТЕСЬ С НАМИ</li>
                    <li class="footer-links">hello@gorod.ru</li>
                    <li class="footer-links">8 800 555-35-35</li>
                    <li class="footer-links">Москва, ул. Городская, 1</li>
                    <li class="footer-links"><a href=""><img src="{{ asset('images/tg.svg') }}" alt=""></a><a href=""><img src="{{ asset('images/vk.svg') }}" alt=""></a></li>
                    </ul>
            </div>
            
        </div>
        <div class="underfooter">
                <div class="underfooter_inner">
                    <p>© 2026 ГОРОД.ру. Все права защищены.</p>
                    <a href="">Пользовательское соглашение</a>
                    <a href="">Политика конфиденциальности</a>
                    <a href="">Публичная оферта</a>
                </div>
            </div>
    </footer>
</body>
</html>