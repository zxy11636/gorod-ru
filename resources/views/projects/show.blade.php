@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="project-page">


    <section class="project-hero">
        <div class="container hero-container">

            <div class="hero-slider">
                <div class="slider-track" id="sliderTrack">
                    @if($project->images && is_array(json_decode($project->images, true)))
                    @foreach(json_decode($project->images, true) as $index => $img)
                    <div class="slide" data-index="{{ $index }}">
                        <img src="{{ Storage::url($img) }}" alt="{{ $project->title }}">
                    </div>
                    @endforeach
                    @else
                    <div class="slide active" data-index="0">
                        <img src="{{ $project->image ? Storage::url($project->image) : asset('images/default-project.jpg') }}" alt="{{ $project->title }}">
                    </div>
                    @endif
                </div>

                <button class="slider-arrow slider-prev" onclick="prevSlide()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 19L8 12L15 5" stroke="#fff" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <button class="slider-arrow slider-next" onclick="nextSlide()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="#fff" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>

                <div class="slide-counter" id="slideCounter">1 / 1</div>
            </div>

            <div class="hero-info">
                <h1 class="project-hero-title">{{ $project->title }}</h1>

                <div class="project-location">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M7 8C7.55228 8 8 7.55228 8 7C8 6.44772 7.55228 6 7 6C6.44772 6 6 6.44772 6 7C6 7.55228 6.44772 8 7 8Z" fill="#94A3B8" />
                        <path d="M7 11C8.5 9.5 10.5 8 10.5 6C10.5 3.79086 8.98528 2 7 2C5.01472 2 3.5 3.79086 3.5 6C3.5 8 5.5 9.5 7 11Z" stroke="#94A3B8" stroke-width="1.2" />
                    </svg>
                    <span>{{ $project->city }}{{ $project->district ? ', ' . $project->district : '' }}</span>
                </div>

                @php
                $color = match($project->category) {
                'parks' => 'green',
                'roads' => 'orange',
                'buildings' => 'gray',
                'sport' => 'blue',
                'culture' => 'purple',
                default => 'gray',
                };
                @endphp

                <span class="category-badge {{ $color }}">
                    {{ $project->category_name }}
                </span>

                <div class="status-badge active">
                    <span class="status-dot"></span>
                    Активный сбор средств
                </div>

                <div class="hero-progress">
                    <div class="progress-big-number">{{ $project->progress_percent }}%</div>
                    <div class="progress-label">собрано</div>
                    <div class="progress-amount">{{ number_format($project->current_amount, 0, '.', ' ') }}₽</div>
                    <div class="progress-goal-label">собрано</div>
                </div>

                @if(auth()->check() && auth()->id() === $project->user_id)
                @else
                <button class="btn-support-hero" onclick="openDonationModal()">Поддержать проект</button>
                @endif
            </div>
        </div>
    </section>

    <div class="container project-main">


        <main class="project-left">

            <section class="content-section">
                <h2 class="section-heading">О проекте</h2>
                <div class="project-text">
                    {!! nl2br(e($project->description)) !!}
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-heading">Что мы сделаем</h2>
                <ul class="features-list">
                    <li class="feature-item">
                        <svg class="feature-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 3L12.5 7.5H17L13.5 11L15 16L10 13L5 16L6.5 11L3 7.5H7.5L10 3Z" stroke="#3B82F6" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                        <span>Сохраним лес и уберем мусор</span>
                    </li>
                    <li class="feature-item">
                        <svg class="feature-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="7" stroke="#3B82F6" stroke-width="1.5" />
                            <path d="M7 10L9 12L13 8" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Построим спортивный комплекс и трассы</span>
                    </li>
                    <li class="feature-item">
                        <svg class="feature-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M4 14L8 6L12 10L16 4" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Создадим зоны отдыха и набережную</span>
                    </li>
                    <li class="feature-item">
                        <svg class="feature-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M6 12C6 12 7 8 10 8C13 8 14 12 14 12" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M8 14C8 14 9 12 10 12C11 12 12 14 12 14" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <span>Запустим фонтан и вольер для птиц</span>
                    </li>
                </ul>
            </section>


            <section class="content-section">
                <h2 class="section-heading">Этапы реализации</h2>
                <div class="timeline">
                    <div class="timeline-item active">
                        <div class="timeline-marker active"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Июль 2024</div>
                            <div class="timeline-title">Сбор средств</div>
                            <div class="timeline-progress">
                                <span class="timeline-percent">{{ $project->progress_percent }}% выполнено</span>
                                <span class="timeline-amount">, собрано {{ number_format($project->current_amount, 0, '.', ' ') }}₽</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item completed">
                        <div class="timeline-marker completed"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Август 2024</div>
                            <div class="timeline-title">Проектирование</div>
                            <div class="timeline-progress">
                                <span class="timeline-percent">100% выполнено</span>
                                <span class="timeline-amount">, утвержден проект</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item active">
                        <div class="timeline-marker active"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Сентябрь–Октябрь 2024</div>
                            <div class="timeline-title">Подготовка площадки</div>
                            <div class="timeline-progress">
                                <span class="timeline-percent">40% выполнено</span>
                                <span class="timeline-amount">, идут работы</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Ноябрь 2024</div>
                            <div class="timeline-title">Озеленение и благоустройство</div>
                            <div class="timeline-progress">
                                <span class="timeline-percent">Запланировано</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">Декабрь 2024</div>
                            <div class="timeline-title">Открытие</div>
                            <div class="timeline-progress">
                                <span class="timeline-percent">Запланировано</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="content-section">
                <h2 class="section-heading">Инициативная группа</h2>
                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #3B82F6, #60A5FA);">ИП</div>
                        <div class="team-name">Иван Петров</div>
                        <div class="team-role">Организатор</div>
                        <a href="mailto:ivan@gorod.ru" class="team-email">ivan@gorod.ru</a>
                    </div>
                    <div class="team-card">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #10B981, #34D399);">АС</div>
                        <div class="team-name">Анна Сидорова</div>
                        <div class="team-role">Архитектор</div>
                        <a href="mailto:annasid@gorod.ru" class="team-email">annasid@gorod.ru</a>
                    </div>
                    <div class="team-card">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #F59E0B, #FBBF24);">СИ</div>
                        <div class="team-name">Сергей Иванов</div>
                        <div class="team-role">Подрядчик</div>
                        <a href="mailto:sergey_i@gorod.ru" class="team-email">sergey_i@gorod.ru</a>
                    </div>
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-heading">Обсуждение <span class="comments-count">({{ $comments->total() ?? 0 }} комментариев)</span></h2>


                @auth
                <form class="comment-form" action="{{ route('comments.store') }}" method="POST" id="commentForm">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="parent_id" id="parentId" value="">

                    <textarea name="content" id="commentContent" placeholder="Напишите комментарий..." required></textarea>
                    <div style="display: flex; gap: 12px; margin-top: 12px;">
                        <button type="submit" class="btn-comment">Отправить</button>
                        <button type="button" class="btn-cancel" id="cancelReply" style="display: none;" onclick="cancelReply()">Отмена</button>
                    </div>
                </form>
                @else
                <p class="text-muted" style="font-size: 14px; color: #64748B;">
                    <a href="#" onclick="openModal(); return false;">Войдите</a>, чтобы оставить комментарий
                </p>
                @endauth


                <div class="comments-list" id="commentsList">
                    @forelse($comments ?? collect() as $comment)
                    @include('projects.partials.comment', ['comment' => $comment, 'depth' => 0])
                    @empty
                    <p class="text-muted" style="text-align: center; padding: 24px;">Комментариев пока нет. Будьте первым!</p>
                    @endforelse
                </div>


                @if(isset($comments) && $comments->hasPages())
                <div style="margin-top: 24px;">
                    {{ $comments->links() }}
                </div>
                @endif
            </section>

        </main>


        <aside class="project-right">


            <div class="sidebar-card">
                <h3 class="sidebar-title">Прогресс сбора</h3>

                <div class="circle-progress-wrapper">
                    <svg class="circle-progress" viewBox="0 0 120 120">
                        <circle class="circle-bg" cx="60" cy="60" r="50" fill="none" stroke="#E2E8F0" stroke-width="12" />
                        <circle class="circle-fill" cx="60" cy="60" r="50" fill="none" stroke="#3B82F6" stroke-width="12"
                            stroke-dasharray="{{ $project->progress_percent * 3.14 }} 314"
                            stroke-dashoffset="0"
                            stroke-linecap="round"
                            transform="rotate(-90 60 60)" />
                    </svg>
                    <div class="circle-center">
                        <span class="circle-percent">{{ $project->progress_percent }}%</span>
                    </div>
                </div>

                <div class="progress-details">
                    <div class="progress-row">
                        <span class="progress-row-label">Собрано:</span>
                        <span class="progress-row-value">{{ number_format($project->current_amount, 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="progress-row">
                        <span class="progress-row-label">Цель:</span>
                        <span class="progress-row-value">{{ number_format($project->goal_amount, 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="progress-row">
                        <span class="progress-row-label">Осталось:</span>
                        <span class="progress-row-value">{{ number_format($project->goal_amount - $project->current_amount, 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="progress-row">
                        <span class="progress-row-label">Средний чек:</span>
                        <span class="progress-row-value">{{ $project->donations->count() > 0 ? number_format($project->current_amount / $project->donations->count(), 0, '.', ' ') : '0' }} ₽</span>
                    </div>
                </div>
            </div>


            @if(auth()->check() && auth()->id() === $project->user_id)

            @else
            <div class="sidebar-card">


                <button class="btn-support-sidebar" onclick="openDonationModal()">Поддержать проект</button>

                <div class="amount-presets">
                    <button type="button" class="amount-btn" onclick="setAmount(500)">500₽</button>
                    <button type="button" class="amount-btn" onclick="setAmount(1000)">1000₽</button>
                    <button type="button" class="amount-btn" onclick="setAmount(5000)">5000₽</button>
                    <button type="button" class="amount-btn active" onclick="setAmount(0)">Другая</button>
                </div>

            </div>
            @endif
        </aside>

    </div>
</div>


<div class="overlay" id="donationOverlay" style="display: none;" onclick="closeDonationModal()"></div>
<div class="modal donation-modal" id="donationModal" style="display: none;">
    <div class="modal__form donation-modal-form">
        <button class="modal__close" onclick="closeDonationModal()">&times;</button>
        <h2 class="modal__title">Поддержать проект</h2>

        <form id="donationForm" action="{{ route('donations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="form-group">
                <label>Сумма пожертвования</label>
                <div class="amount-presets-modal">
                    <button type="button" class="amount-btn-modal" data-amount="500" onclick="selectAmount(this, 500)">500 ₽</button>
                    <button type="button" class="amount-btn-modal" data-amount="1000" onclick="selectAmount(this, 1000)">1 000 ₽</button>
                    <button type="button" class="amount-btn-modal" data-amount="2500" onclick="selectAmount(this, 2500)">2 500 ₽</button>
                    <button type="button" class="amount-btn-modal" data-amount="5000" onclick="selectAmount(this, 5000)">5 000 ₽</button>
                </div>
                <input type="number" id="donationAmount" name="amount" placeholder="Другая сумма" min="100" step="100" required>
            </div>

            <div class="form-group">
                <label>Комментарий (необязательно)</label>
                <textarea name="comment" rows="3" placeholder="Пожелание автору проекта..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Перейти к оплате</button>
            <p class="donation-secure">🔒 Оплата защищена протоколом SSL</p>
        </form>
    </div>
</div>

<script>
    
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    function updateSlider() {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === currentSlide);
        });
        document.getElementById('slideCounter').textContent = `${currentSlide + 1} / ${totalSlides}`;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }

    
    function openDonationModal() {
        document.getElementById('donationOverlay').style.display = 'block';
        document.getElementById('donationModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDonationModal() {
        document.getElementById('donationOverlay').style.display = 'none';
        document.getElementById('donationModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    
    function setAmount(amount) {
        document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
        event.target.classList.add('active');
        if (amount > 0) document.getElementById('donationAmount').value = amount;
    }

    function selectAmount(btn, amount) {
        document.querySelectorAll('.amount-btn-modal').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('donationAmount').value = amount;
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDonationModal();
    });
</script>

@push('scripts')
<script>
    
    document.getElementById('commentForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok && data.success) {
                
                const commentsList = document.getElementById('commentsList');
                const newComment = renderComment(data.comment);
                commentsList.insertAdjacentHTML('afterbegin', newComment);

                
                form.reset();
                document.getElementById('parentId').value = '';
                document.getElementById('cancelReply').style.display = 'none';
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Не удалось отправить комментарий');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    
    function renderComment(c) {
        const avatar = c.user.avatar ? `<img src="/storage/${c.user.avatar}" class="comment-avatar">` :
            `<div class="comment-avatar" style="background: linear-gradient(135deg, #3B82F6, #60A5FA);">${c.user.name.charAt(0).toUpperCase()}</div>`;

        return `
        <div class="comment-item" id="comment-${c.id}">
            <div class="comment-header">
                ${avatar}
                <div>
                    <div class="comment-author">${c.user.name}</div>
                    <div class="comment-date">${c.created_at}</div>
                </div>
            </div>
            <div class="comment-text">${c.content}</div>
            <div class="comment-actions">
                <button class="comment-action like" onclick="voteComment(${c.id}, 'like')">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 8L6 4V8H10L8 12V8H2Z" stroke="#94A3B8" stroke-width="1.2"/></svg>
                    <span id="likes-${c.id}">${c.likes}</span>
                </button>
                <button class="comment-action dislike" onclick="voteComment(${c.id}, 'dislike')">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M14 8L10 12V8H6L8 4V8H14Z" stroke="#94A3B8" stroke-width="1.2"/></svg>
                    <span id="dislikes-${c.id}">${c.dislikes}</span>
                </button>
            </div>
        </div>
    `;
    }

    
    async function voteComment(id, type) {
        try {
            const response = await fetch(`/comments/${id}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    type
                }),
            });

            const data = await response.json();
            if (data.success) {
                document.getElementById(`likes-${id}`).textContent = data.likes;
                document.getElementById(`dislikes-${id}`).textContent = data.dislikes;
            }
        } catch (e) {
            console.error(e);
        }
    }

    
    function replyToComment(parentId) {
        document.getElementById('parentId').value = parentId;
        document.getElementById('cancelReply').style.display = 'inline-block';
        document.getElementById('commentContent').focus();
    }

    function cancelReply() {
        document.getElementById('parentId').value = '';
        document.getElementById('cancelReply').style.display = 'none';
    }

    
    function editComment(id) {
        const content = document.getElementById(`content-${id}`);
        const newText = prompt('Редактировать комментарий:', content.textContent);
        if (newText && newText !== content.textContent) {
            fetch(`/comments/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    content: newText
                }),
            }).then(() => location.reload());
        }
    }
</script>
@endpush
@endsection