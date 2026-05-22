<header>
    <div class="container">
        <div class="header_inner">
            <div class="logo">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo">
                <span>Город.ру</span>
            </div>
            <nav class="header_nav">
                <div class="header_nav-item active"><a href="{{ route('home') }}">Главная</a></div>
                <div class="header_nav-item"><a href="#">Проекты</a></div>
                <div class="header_nav-item"><a href="#">Карта</a></div>
                <div class="header_nav-item"><a href="#">О нас</a></div>
            </nav>
            <div class="header-btns">
                @auth
                    <a href="{{ route('dashboard') }}" class="login">Личный кабинет</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="offer">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="login">Войти</a>
                    <a href="{{ route('register') }}" class="offer">Предложить проект</a>
                @endauth
            </div>
        </div>
    </div>
</header>