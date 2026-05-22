@extends('layouts.app')

@section('title', 'Как это работает')

@section('content')
<div class="how-it-works-page">
    <div class="container">
        
        <!-- Заголовок -->
        <div class="page-header">
            <a href="{{ route('home') }}" class="back-link">← На главную</a>
            <h1 class="page-title">Как работает Город.ру</h1>
            <p class="page-subtitle">Мы даем инструменты для сбора средств. Вы меняете город.</p>
        </div>

        <!-- Две карточки: Автор и Донатер -->
        <div class="roles-grid">
            <div class="role-card author">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M24 4L28 20H44L32 32L36 48L24 38L12 48L16 32L4 20H20L24 4Z" fill="#3B82F6" opacity="0.2"/>
                        <path d="M24 8L27 20H39L30 29L33 41L24 34L15 41L18 29L9 20H21L24 8Z" fill="#3B82F6"/>
                    </svg>
                </div>
                <h2 class="role-title">АВТОР</h2>
                <p class="role-subtitle">(инициатор)</p>
                <ul class="role-list">
                    <li><span class="check">✓</span> Придумывает идею</li>
                    <li><span class="check">✓</span> Подает заявку</li>
                    <li><span class="check">✓</span> Ищет подрядчиков</li>
                    <li><span class="check">✓</span> Контролирует работы</li>
                </ul>
            </div>

            <div class="role-card donor">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M24 4C12.954 4 4 12.954 4 24s8.954 20 20 20 20-8.954 20-20S35.046 4 24 4zm0 36c-8.837 0-16-7.163-16-16S15.163 8 24 8s16 7.163 16 16-7.163 16-16 16z" fill="#10B981" opacity="0.2"/>
                        <path d="M24 14c-5.523 0-10 4.477-10 10s4.477 10 10 10 10-4.477 10-10-4.477-10-10-10zm0 16c-3.314 0-6-2.686-6-6s2.686-6 6-6 6 2.686 6 6-2.686 6-6 6z" fill="#10B981"/>
                        <path d="M26 22h-2v2h2v-2zm0-4h-2v2h2v-2z" fill="#10B981"/>
                    </svg>
                </div>
                <h2 class="role-title">ДОНАТЕР</h2>
                <p class="role-subtitle">(инвестор)</p>
                <ul class="role-list">
                    <li><span class="check-green">✓</span> Переводит деньги</li>
                    <li><span class="check-green">✓</span> Получает налоговый вычет 13%</li>
                    <li><span class="check-green">✓</span> Следит за отчетами</li>
                    <li><span class="check-green">✓</span> Помогает советами</li>
                </ul>
            </div>
        </div>

        <!-- Этапы работы сервиса -->
        <section class="workflow-section">
            <h2 class="section-title">Этапы работы сервиса</h2>
            
            <div class="workflow-columns">
                <div class="workflow-column">
                    <div class="column-header">"ПУТЬ АВТОРА"</div>
                    <div class="workflow-step">
                        <div class="step-title">ИДЕЯ</div>
                    </div>
                    <div class="workflow-step">
                        <div class="step-title">ЗАЯВКА</div>
                    </div>
                    <div class="workflow-step">
                        <div class="step-title">МОДЕРАЦИЯ</div>
                    </div>
                </div>

                <div class="workflow-column center">
                    <div class="column-header">"ОБЩИЕ ЭТАПЫ"</div>
                    <div class="workflow-step">
                        <div class="step-title">КОНТРОЛЬ</div>
                    </div>
                    <div class="workflow-step">
                        <div class="step-title">РЕАЛИЗАЦИЯ</div>
                    </div>
                </div>

                <div class="workflow-column">
                    <div class="column-header">"ПУТЬ ДОНАТЕРА"</div>
                    <div class="workflow-step">
                        <div class="step-title">ВЫБОР</div>
                    </div>
                    <div class="workflow-step">
                        <div class="step-title">ДОНАТ</div>
                    </div>
                    <div class="workflow-step">
                        <div class="step-title">КОНТРОЛЬ</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Как это работает — по шагам -->
        <section class="hiw-section">
    <h2 class="section-title">Как это работает — по шагам</h2>

    <!-- Шаг 1: Подготовка -->
    <div class="hiw-card large">
        <div class="hiw-card-header">
            <div class="hiw-number">1</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">ПОДГОТОВКА</h3>
            <p class="hiw-subtitle">Как подготовить проект к подаче</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Придумайте конкретную идею</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Найдите фото/эскизы</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Сделайте примерную смету</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Опишите пользу для города</div>
            </div>
        </div>
    </div>

    <!-- Шаг 2: Подача заявки -->
    <div class="hiw-card large">
        <div class="hiw-card-header">
            <div class="hiw-number">2</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">ПОДАЧА ЗАЯВКИ</h3>
            <p class="hiw-subtitle">Как заполнить форму</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Название проекта</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Смета и сроки</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Описание и цели</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Контактные данные</div>
            </div>
        </div>
    </div>

    <!-- Шаг 3: Модерация -->
    <div class="hiw-card large">
        <div class="hiw-card-header">
            <div class="hiw-number">3</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">МОДЕРАЦИЯ</h3>
            <p class="hiw-subtitle">Проверка платформой</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Проверка за 1-3 дня</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Одобрение или доработка</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Уточнение деталей</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Публикация на сайте</div>
            </div>
        </div>
    </div>

    <!-- Шаг 4: Сбор средств (градиент) -->
    <div class="hiw-card large shared">
        <div class="hiw-card-header">
            <div class="hiw-number success">4</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">СБОР СРЕДСТВ</h3>
            <p class="hiw-subtitle">Проект собирает донаты</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Проект появляется в каталоге</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Автор продвигает проект</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Люди переводят деньги</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Прогресс отображается</div>
            </div>
        </div>
    </div>

    <!-- Шаг 5: Реализация (градиент) -->
    <div class="hiw-card large shared">
        <div class="hiw-card-header">
            <div class="hiw-number success">5</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">РЕАЛИЗАЦИЯ</h3>
            <p class="hiw-subtitle">Строительство и отчеты</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Поиск подрядчика</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Фотоотчеты</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Контроль работ</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Финансовые отчеты</div>
            </div>
        </div>
    </div>

    <!-- Для донатеров: Выбор проекта -->
    <div class="hiw-card large donor">
        <div class="hiw-card-header">
            <div class="hiw-number donor">1</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">ВЫБОР ПРОЕКТА</h3>
            <p class="hiw-subtitle">Как найти, что поддержать</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Поиск по категориям</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Просмотр на карте</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Фильтры по городу</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Чтение описаний</div>
            </div>
        </div>
    </div>

    <!-- Для донатеров: Перевод денег -->
    <div class="hiw-card large donor">
        <div class="hiw-card-header">
            <div class="hiw-number donor">2</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">ПЕРЕВОД ДЕНЕГ</h3>
            <p class="hiw-subtitle">Как сделать донат</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Выбор суммы</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Получение чека</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Оплата картой или СБП</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Налоговый вычет 13%</div>
            </div>
        </div>
    </div>

    <!-- Для донатеров: Контроль -->
    <div class="hiw-card large donor">
        <div class="hiw-card-header">
            <div class="hiw-number donor">3</div>
            <div class="hiw-label">ШАГ</div>
        </div>
        <div class="hiw-content">
            <h3 class="hiw-title">КОНТРОЛЬ РЕАЛИЗАЦИИ</h3>
            <p class="hiw-subtitle">Как следить за проектом</p>
            <div class="hiw-grid">
                <div class="hiw-item"><span class="hiw-check">✓</span> Получение уведомлений</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Чтение финансовых отчетов</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Просмотр фотоотчетов</div>
                <div class="hiw-item"><span class="hiw-check">✓</span> Комментарии и вопросы</div>
            </div>
        </div>
    </div>
</section>

        <!-- FAQ -->
        <section class="faq-section">
            <h2 class="section-title">Часто задаваемые вопросы</h2>
            <p class="faq-subtitle">Ответы на самые популярные вопросы о сервисе</p>

            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Кто может привлекать инвестиции?
                        <svg class="faq-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Официально запустить сбор средств на нашей платформе могут:</p>
                        <ul>
                            <li>Некоммерческие организации (НКО, фонды)</li>
                            <li>Территориальные общественные самоуправления (ТОС)</li>
                            <li>Индивидуальные предприниматели</li>
                            <li>Муниципальные учреждения</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Сколько времени занимает модерация?
                        <svg class="faq-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Обычно модерация занимает 1-3 рабочих дня. Если проект требует доработки, мы сообщим вам конкретные замечания.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Как автор получает деньги?
                        <svg class="faq-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Деньги аккумулируются на специальном счете платформы. После успешного сбора средств и подтверждения реализации проекта, средства переводятся на расчетный счет организации-автора.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Что если не удалось собрать всю сумму?
                        <svg class="faq-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Если сбор средств не достиг цели, вы можете:<br>
                        • Продлить срок сбора<br>
                        • Скорректировать бюджет проекта<br>
                        • Вернуть средства донаторам (полностью или частично)</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Нужно ли платить налоги?
                        <svg class="faq-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <p>Для донаторов: пожертвования не облагаются НДФЛ, и вы можете получить налоговый вычет 13%.<br><br>
                        Для авторов: НКО и ТОС освобождены от налогов при целевом использовании средств. ИП и юрлица платят налоги согласно своей системе налогообложения.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script>
function toggleFaq(button) {
    const item = button.parentElement;
    const answer = button.nextElementSibling;
    const icon = button.querySelector('.faq-icon');
    
    item.classList.toggle('active');
    
    if (item.classList.contains('active')) {
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.style.maxHeight = '0';
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection