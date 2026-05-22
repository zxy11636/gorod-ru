@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<section class="hero">

    <div class="hero-bg-glow"></div>

    <div class="container">
        <div class="hero_inner">

            <div class="hero_content animate-on-scroll fade-in-left">

                <div class="hero-badge">
                    <span>● Платформа городских инициатив</span>
                </div>

                <div class="hero_title">
                    Ваш город —
                    <br>
                    в ваших руках
                </div>

                <div class="hero_text">
                    Предлагайте, поддерживайте и финансируйте
                    реальные проекты для своего города.
                    От благоустройства дворов до реставрации
                    памятников — изменения начинаются здесь.
                </div>

                <div class="hero_links">

                    <a href="{{ route('projects.index') }}" class="hero-btn">
                        <span>Выбрать проект</span>
                        <img src="{{ asset('images/arrow.svg') }}" alt="">
                    </a>

                    <a href="{{ route('how-it-works') }}" class="hero-link-secondary">
                        Как это работает?
                    </a>

                </div>

            </div>

            <div class="hero-img animate-on-scroll fade-in-right">

                <div class="hero-image-card">
                    <img src="{{ asset('images/hero-phot.png')}}" alt="">
                </div>

                <div class="hero-floating-card hero-card-1">
                    <span class="hero-card-number">12 000+</span>
                    <span class="hero-card-text">жителей участвуют</span>
                </div>

                <div class="hero-floating-card hero-card-2">
                    <span class="hero-card-number">148</span>
                    <span class="hero-card-text">проектов реализовано</span>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="steps">

    <div class="container">

        <div class="steps-header animate-on-scroll fade-in">

            <div class="steps-badge">
                Как это работает
            </div>

            <h2 class="steps-title">
                Три шага к изменениям
                <br>
                в вашем городе
            </h2>

            <p class="steps-subtitle">
                Простая и прозрачная система участия
                в развитии городской среды
            </p>

        </div>

        <div class="steps-wrapper">


            <div class="steps-line"></div>


            <div class="step-card animate-on-scroll stagger-animation" style="--delay: 0.1s">

                <div class="step-top">
                    <div class="step-icon blue">
                        <img src="{{ asset('images/search-icon.svg') }}" alt="">
                    </div>

                    <div class="step-number">
                        01
                    </div>
                </div>

                <h3 class="step-title">
                    Найдите проект
                    или предложите свой
                </h3>

                <p class="step-text">
                    Создайте инициативу или поддержите
                    идеи жителей вашего города
                </p>

            </div>

            <div class="step-card animate-on-scroll stagger-animation active" style="--delay: 0.3s">

                <div class="step-top">
                    <div class="step-icon green">
                        <img src="{{ asset('images/support-icon.svg') }}" alt="">
                    </div>

                    <div class="step-number">
                        02
                    </div>
                </div>

                <h3 class="step-title">
                    Поддержите проект
                </h3>

                <p class="step-text">
                    Голосуйте или финансируйте
                    инициативы напрямую
                </p>

            </div>

            <div class="step-card animate-on-scroll stagger-animation" style="--delay: 0.5s">

                <div class="step-top">
                    <div class="step-icon red">
                        <img src="{{ asset('images/track-icon.svg') }}" alt="">
                    </div>

                    <div class="step-number">
                        03
                    </div>
                </div>

                <h3 class="step-title">
                    Следите
                    за реализацией
                </h3>

                <p class="step-text">
                    Получайте отчёты и наблюдайте,
                    как меняется город
                </p>

            </div>

        </div>

    </div>

</section>

<section class="feat-section">
    <div class="container">

        <div class="feat-header animate-on-scroll">
            <h2 class="feat-title">Популярные проекты</h2>
            <p class="feat-subtitle">Инициативы, которые уже меняют города к лучшему</p>
        </div>

        <div class="feat-grid">
            @php
            $featured = \App\Models\Project::where('status', 'active')
            ->orderBy('current_amount', 'desc')
            ->take(3)
            ->get();
            @endphp

            @forelse($featured as $project)
            <article class="feat-card animate-on-scroll fade-in-up">
                <a href="{{ route('project.show', $project->id) }}" class="feat-card-link">

                    <div class="feat-card-image">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/default-project.jpg') }}"
                            alt="{{ $project->title }}" loading="lazy">
                        <span class="feat-badge {{ $project->badge_color ?? 'blue' }}">
                            {{ $project->category_name ?? $project->category }}
                        </span>
                    </div>

                    <div class="feat-card-body">
                        <h3 class="feat-card-title">{{ Str::limit($project->title, 50) }}</h3>

                        <div class="feat-location">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 8C7.55228 8 8 7.55228 8 7C8 6.44772 7.55228 6 7 6C6.44772 6 6 6.44772 6 7C6 7.55228 6.44772 8 7 8Z" fill="#94A3B8" />
                                <path d="M7 11C8.5 9.5 10.5 8 10.5 6C10.5 3.79086 8.98528 2 7 2C5.01472 2 3.5 3.79086 3.5 6C3.5 8 5.5 9.5 7 11Z" stroke="#94A3B8" stroke-width="1.2" />
                            </svg>
                            <span>{{ $project->city }}</span>
                        </div>

                        <div class="feat-progress">
                            <div class="feat-progress-bar">
                                <div class="feat-progress-fill" style="width: {{ min(100, $project->goal_amount > 0 ? ($project->current_amount / $project->goal_amount) * 100 : 0) }}%"></div>
                            </div>
                            <div class="feat-progress-text">
                                <span class="feat-raised">{{ number_format($project->current_amount, 0, '.', ' ') }} ₽</span>
                                <span class="feat-goal">из {{ number_format($project->goal_amount, 0, '.', ' ') }} ₽</span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>
            @empty
            <div class="feat-empty">
                <p>Проекты скоро появятся! Следите за обновлениями 👀</p>
                <a href="{{ route('how-it-works') }}" class="feat-btn-outline">Как предложить идею? →</a>
            </div>
            @endforelse
        </div>

        <div class="feat-footer animate-on-scroll">
            <a href="{{ route('projects.index') }}" class="feat-btn-all">
                Смотреть все проекты
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M4 8H12M12 8L8 4M12 8L8 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

    </div>
</section>

<section class="projects-section">
    <div class="container">

        <div class="projects-header animate-on-scroll fade-in">
            <h2 class="projects-title">Поддержите проекты, которые меняют город</h2>
            <p class="projects-subtitle">Самые обсуждаемые и близкие к завершению инициативы</p>

            <div class="projects-tabs">
                <button class="tab active">Все проекты</button>
                <button class="tab">Близкие к завершению</button>
            </div>
        </div>

        <div class="projects-slider">
            <button class="slider-arriw slider-arrow-left">
                <img src="{{ asset('images/slider_arrow-left.svg') }}" alt="←">
            </button>

            <div class="projects-slider-wrapper">
                <div class="projects-grid">
                    @forelse($activeProjects as $index => $project)
                    <div class="project-card animate-on-scroll stagger-animation"
                        style="--delay: {{ 0.1 + ($index * 0.1) }}s">
                        <div class="card-image">
                            <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/project-' . (($index % 3) + 1) . '.jpg') }}"
                                alt="{{ $project->title }}">
                            <span class="card-badge {{ $project->badge_color }}">
                                {{ $project->category_name }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{ $project->title }}</h3>
                            <div class="card-location">
                                <img src="{{ asset('images/pin.svg') }}" alt="📍">
                                <span>г. {{ $project->city }}, {{ $project->district }}</span>
                            </div>
                            <div class="card-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                        style="width: {{ $project->progress_percent }}%;">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="card-money">
                                    <span class="raised">{{ $project->formatted_current }}</span>
                                    <span class="divider">/</span>
                                    <span class="goal">{{ $project->formatted_goal }}</span>
                                </div>
                                <a href="{{ route('project.show', $project->id) }}" class="card-btn" style="text-decoration: none; text-align: center;">
                                    Поддержать
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p>Нет активных проектов</p>
                    @endforelse
                </div>
            </div>

            <button class="slider-arriw slider-arrow-right">
                <img src="{{ asset('images/slider_arrow-right.svg') }}" alt="→">
            </button>
        </div>

    </div>
</section>

<section class="completed-projects">
    <div class="container">

        <div class="completed-header">
            <h2 class="completed-title">Уже изменили город к лучшему</h2>
            <p class="completed-subtitle">Реальные проекты, реализованные благодаря вашей поддержке</p>
        </div>

        <div class="completed-grid">

            <div class="completed-card animate-on-scroll stagger-animation" style="--delay: 0.1s">
                <div class="before-after">
                    <div class="ba-image">
                        <img src="{{ asset('images/park-before.jpg') }}" alt="Парк Орленок до">
                        <span class="ba-label">до</span>
                    </div>
                    <div class="ba-image">
                        <img src="{{ asset('images/park-after.jpg') }}" alt="Парк Орленок после">
                        <span class="ba-label">после</span>
                    </div>
                </div>
                <div class="completed-content">
                    <h3 class="completed-card-title">Парк Орленок</h3>
                    <div class="completed-stats">

                        <div class="stat">
                            <span class="stat-label">Собрано</span>
                            <span class="stat-value">30 000 000 ₽</span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">Голосов</span>
                            <span class="stat-value">3 200</span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">Открыт</span>
                            <span class="stat-value">12.06.2023</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="completed-card animate-on-scroll stagger-animation" style="--delay: 0.3s">
                <div class="before-after">
                    <div class="ba-image">
                        <img src="{{ asset('images/road-before.jpg') }}" alt="Дорога до">
                        <span class="ba-label">до</span>
                    </div>
                    <div class="ba-image">
                        <img src="{{ asset('images/road-after.jpg') }}" alt="Дорога после">
                        <span class="ba-label">после</span>
                    </div>
                </div>
                <div class="completed-content">
                    <h3 class="completed-card-title">Дорога Ул. Ленина</h3>
                    <div class="completed-stats">

                        <div class="stat">
                            <span class="stat-label">Собрано</span>
                            <span class="stat-value">30 000 000 ₽</span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">Голосов</span>
                            <span class="stat-value">3 200</span>
                        </div>

                        <div class="stat">
                            <span class="stat-label">Открыт</span>
                            <span class="stat-value">12.06.2023</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection