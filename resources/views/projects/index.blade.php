@extends('layouts.app')

@section('title', 'Все проекты')

@section('content')
<div class="projects-list-page">
    <div class="container">

        <div class="projects-header">
            <h1 class="projects-page-title">Все проекты вашего города</h1>
            <p class="projects-page-subtitle">Найдите и поддержите инициативы, которые сделают ваш город лучше</p>
        </div>

        <div class="projects-layout">
            <button class="mobile-filter-toggle" id="mobileFilterToggle">
                <span>Фильтры</span>

                <svg class="mobile-filter-icon"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none">
                    <path d="M6 9L12 15L18 9"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <aside class="projects-sidebar" id="projectsSidebar">

                <form action="{{ route('projects.index') }}" method="GET" id="filterForm">

                    <!-- Поиск -->
                    <div class="filter-section">
                        <div class="search-wrapper">
                            <svg class="search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M12.75 12.75L16.5 16.5M8.25 13.5C11.1495 13.5 13.5 11.1495 13.5 8.25C13.5 5.35051 11.1495 3 8.25 3C5.35051 3 3 5.35051 3 8.25C3 11.1495 5.35051 13.5 8.25 13.5Z"
                                    stroke="#94A3B8" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <input type="text"
                                name="search"
                                placeholder="Поиск проектов..."
                                value="{{ request('search') }}"
                                class="search-input"
                                onchange="this.form.submit()">
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Категория</h3>
                        <ul class="filter-list">
                            @foreach($categories as $slug => $category)
                            <li class="filter-item">
                                <label class="filter-label">
                                    <input type="radio"
                                        name="category"
                                        value="{{ $slug }}"
                                        {{ request('category') == $slug ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="filter-radio">
                                    <span class="filter-text">
                                        {{ $category['label'] }}
                                        <span class="filter-count">({{ $category['count'] }})</span>
                                    </span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Статус проекта</h3>
                        <ul class="filter-list">
                            <li class="filter-item">
                                <label class="filter-label">
                                    <input type="radio"
                                        name="status"
                                        value="active"
                                        {{ request('status') == 'active' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="filter-radio">
                                    <span class="filter-text">
                                        Активные (сбор средств)
                                        <span class="status-indicator active"></span>
                                    </span>
                                </label>
                            </li>
                            <li class="filter-item">
                                <label class="filter-label">
                                    <input type="radio"
                                        name="status"
                                        value="voting"
                                        {{ request('status') == 'voting' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="filter-radio">
                                    <span class="filter-text">
                                        На голосовании
                                        <span class="status-indicator voting"></span>
                                    </span>
                                </label>
                            </li>
                            <li class="filter-item">
                                <label class="filter-label">
                                    <input type="radio"
                                        name="status"
                                        value="completed"
                                        {{ request('status') == 'completed' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="filter-radio">
                                    <span class="filter-text">
                                        Реализованные
                                        <span class="status-indicator completed"></span>
                                    </span>
                                </label>
                            </li>
                            <li class="filter-item">
                                <label class="filter-label">
                                    <input type="radio"
                                        name="status"
                                        value=""
                                        {{ request('status') === '' || request('status') === null ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="filter-radio">
                                    <span class="filter-text">Все</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                </form>

                @if(request('category') || request('status') || request('search'))
                <div class="reset-filters-wrapper">
                    <a href="{{ route('projects.index') }}" class="reset-filters-btn">
                        Сбросить все фильтры
                    </a>
                </div>
                @endif

            </aside>


            <main class="projects-main">

                @forelse($projects as $project)
                <article class="project-card-large">
                    <div class="project-card-image">
                        <img src="{{ $project->image ? asset('storage/' . ltrim($project->image, '/')) : asset('images/default-project.jpg') }}"
                            alt="{{ $project->title }}"
                            loading="lazy"
                            class="project-card-img">
                        <span class="project-badge {{ $project->badge_color ?? 'blue' }}">
                            {{ $project->category_name }}
                        </span>
                    </div>

                    <div class="project-card-content">
                        <h3 class="project-card-title">{{ $project->title }}</h3>

                        <div class="project-card-location">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 8.5C7.82843 8.5 8.5 7.82843 8.5 7C8.5 6.17157 7.82843 5.5 7 5.5C6.17157 5.5 5.5 6.17157 5.5 7C5.5 7.82843 6.17157 8.5 7 8.5Z" fill="#94A3B8" />
                                <path d="M7 12C9.5 9.5 12 7.5 12 5C12 2.79086 10.2091 1 7 1C3.79086 1 2 2.79086 2 5C2 7.5 4.5 9.5 7 12Z" stroke="#94A3B8" stroke-width="1.5" />
                            </svg>
                            <span>. {{ $project->city }}{{ $project->district ? ', ' . $project->district : '' }}</span>
                        </div>

                        <div class="project-card-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $project->progress_percent }}%;"></div>
                            </div>
                        </div>

                        <div class="project-card-footer">
                            <div class="project-card-money">
                                <span class="money-raised">{{ $project->formatted_current }}</span>
                                <span class="money-divider">/</span>
                                <span class="money-goal">{{ $project->formatted_goal }}</span>
                            </div>

                            <a href="{{ route('project.show', $project->id) }}" class="project-card-link">
                                Подробнее →
                            </a>
                        </div>
                    </div>
                </article>
                @empty
                <div class="projects-empty">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="40" fill="#F1F5F9" />
                        <path d="M40 25V40L50 45" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <h3>Проекты не найдены</h3>
                    <p>Попробуйте изменить параметры поиска или фильтры</p>
                    @if(request()->filled(['category', 'status', 'search']))
                    <a href="{{ route('projects.index') }}" class="btn-reset">Сбросить фильтры</a>
                    @endif
                </div>
                @endforelse

                @if($projects->hasPages())
                <div class="projects-pagination">
                    {{ $projects->links() }}
                </div>
                @endif

            </main>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const toggleBtn = document.getElementById('mobileFilterToggle');
        const sidebar = document.getElementById('projectsSidebar');

        if (toggleBtn && sidebar) {

            toggleBtn.addEventListener('click', function() {

                sidebar.classList.toggle('active');
                toggleBtn.classList.toggle('active');

            });

        }

    });
</script>
@endsection