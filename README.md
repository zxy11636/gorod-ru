# Город.ру — Платформа городских инициатив

Веб-приложение, где жители города предлагают инициативы по улучшению городской среды, голосуют за предложения других и обсуждают идеи.

Дипломный проект по специальности «Веб-разработка».

<!-- Раскомментируй и вставь ссылку на скриншот: -->
<!-- ![Главная страница](screenshots/main.png) -->

## Возможности

- Регистрация и авторизация пользователей
- Создание инициатив с описанием и категорией
- Голосование за инициативы
- Комментирование и обсуждение
- Общий layout с хедером и футером (app.blade.php)

## Стек

- **Backend:** PHP 8, Laravel (MVC, Eloquent ORM, миграции)
- **Frontend:** Blade-шаблоны, JavaScript
- **База данных:** MySQL
- **Сборка:** Vite

## Установка и запуск

```bash
# Клонировать репозиторий
git clone https://github.com/zxy11636/gorod-ru.git
cd gorod-ru

# Установить зависимости
composer install
npm install

# Настроить окружение
cp .env.example .env
php artisan key:generate

# Указать параметры БД в .env:
# DB_DATABASE=gorod
# DB_USERNAME=root
# DB_PASSWORD=

# Выполнить миграции
php artisan migrate

# Запустить
php artisan serve
npm run dev
```

Приложение будет доступно по адресу `http://localhost:8000`.

## Структура проекта

```
gorod-ru/
├── app/            # Модели, контроллеры, middleware
├── config/         # Конфигурация Laravel
├── database/       # Миграции и сиды
├── resources/      # Blade-шаблоны (layout, страницы), JS
├── routes/         # Маршруты (web.php)
├── public/         # Публичные файлы
└── tests/          # Тесты
```

## Автор

**Матвей Семахин** — [Telegram](https://t.me/tutaNETU) · [Email](mailto:prodzxy@mail.ru)
