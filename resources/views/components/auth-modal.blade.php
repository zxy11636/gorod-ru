{{-- resources/views/components/auth-modal.blade.php --}}
<div class="overlay" id="authOverlay" style="display: none;"></div>

<div class="modal" id="authModal" style="display: none;">
  <!-- Левая часть — изображение -->
  <div class="modal__image">
    <div class="cityscape"></div>
    {{-- Или реальное изображение: --}}
    {{-- <img src="{{ asset('images/cityscape.jpg') }}" alt="Город"> --}}
  </div>

  <!-- Правая часть — форма -->
  <div class="modal__form">
    <button class="modal__close" id="authModalClose" aria-label="Закрыть">&times;</button>
    <h2 class="modal__title">Регистрация</h2>

    <form id="regForm" autocomplete="off" method="POST" action="{{ route('register') }}">
      @csrf

      <div class="form-group">
        <label for="passport">Серия и номер паспорта</label>
        <input type="text" id="passport" name="passport" placeholder="000000 0000" maxlength="10" required>
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
        <label for="password_confirmation">Повторите пароль</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
      </div>

      <button type="submit" class="btn-submit">Зарегистрироваться</button>
    </form>

    <p class="login-link">Уже есть аккаунт? <a href="#" id="switchToLogin">Войти</a></p>
  </div>
</div>