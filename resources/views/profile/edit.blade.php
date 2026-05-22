@extends('layouts.app')

@section('title', 'Мой профиль')

@section('content')
<div class="profile-page">
    <div class="container">

        {{-- HEADER --}}
        <div class="profile-topbar">
            <div>
                <h1 class="profile-title">Мой профиль</h1>
                <p class="profile-subtitle">
                    Управляйте аккаунтом, проектами и активностью
                </p>
            </div>

            <div class="profile-stats">
                @if($user->role === 'author')
                <div class="profile-stat-card">
                    <span class="profile-stat-value">{{ $user->projects->count() ?? 0 }}</span>
                    <span class="profile-stat-label">Проектов</span>
                </div>
                @else
                <div class="profile-stat-card">
                    <span class="profile-stat-value">{{ $donations->count() ?? 0 }}</span>
                    <span class="profile-stat-label">Донатов</span>
                </div>
                @endif

                <div class="profile-stat-card">
                    <span class="profile-stat-value">
                        {{ $user->created_at->diffForHumans(null, true) }}
                    </span>
                    <span class="profile-stat-label">С нами</span>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        {{-- PROFILE CARD --}}
        <div class="profile-card">

            <div class="profile-card-glow"></div>

            <form id="profileForm"
                action="{{ route('profile.update') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PATCH')

                <div class="profile-header">

                    {{-- AVATAR --}}
                    <div class="profile-avatar-wrapper">

                        @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}"
                            alt="{{ $user->name }}"
                            class="profile-avatar"
                            id="avatarPreview">
                        @else
                        <div class="profile-avatar-placeholder" id="avatarPreview">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>
                        @endif

                        <input type="file"
                            id="avatarInput"
                            name="avatar"
                            accept="image/*"
                            style="display:none;"
                            onchange="previewAvatar(this)">

                        <button type="button"
                            class="profile-avatar-edit"
                            onclick="document.getElementById('avatarInput').click()">

                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M11.5 3.5L3.5 11.5M3.5 11.5V12.5H4.5L12.5 4.5L11.5 3.5ZM12.5 4.5L13.5 3.5C13.8333 3.16667 14.3333 3.16667 14.6667 3.5C15 3.83333 15 4.33333 14.6667 4.66667L13.5 5.83333L12.5 4.5Z"
                                    stroke="#fff"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    {{-- INFO --}}
                    <div class="profile-info">

                        <div class="profile-name-wrapper">

                            <h2 class="profile-name" id="nameDisplay">
                                {{ $user->name }}
                            </h2>

                            <button type="button"
                                class="profile-name-edit"
                                onclick="editName()"
                                id="editNameBtn">

                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M10 3L11 4L4 11H3V10L10 3Z"
                                        stroke="#64748B"
                                        stroke-width="1.2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        {{-- EDIT NAME --}}
                        <div id="nameInputWrapper" style="display:none;">

                            <input type="text"
                                id="nameInput"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="profile-name-input"
                                maxlength="255"
                                onkeydown="if(event.key === 'Enter'){event.preventDefault();saveName();}">

                            <div class="name-input-actions">
                                <button type="button"
                                    class="btn-small btn-save"
                                    onclick="saveName()">
                                    Сохранить
                                </button>

                                <button type="button"
                                    class="btn-small btn-cancel"
                                    onclick="cancelNameEdit()">
                                    Отмена
                                </button>
                            </div>
                        </div>

                        <div class="profile-meta">

                            <div class="profile-meta-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 6L12 13L20 6"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                <span>{{ $user->email }}</span>
                            </div>

                            <div class="profile-meta-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                        stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M20 21C20 17.134 16.866 14 13 14H11C7.13401 14 4 17.134 4 21"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>

                                <span>
                                    {{ $user->role === 'author' ? 'Автор проектов' : 'Донатер' }}
                                </span>
                            </div>

                            <div class="profile-meta-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M8 2V5M16 2V5M3 9H21"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round" />
                                    <rect x="3" y="5"
                                        width="18"
                                        height="16"
                                        rx="2"
                                        stroke="currentColor"
                                        stroke-width="2" />
                                </svg>

                                <span>
                                    На сайте с {{ $user->created_at->format('F Y') }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- AUTHOR --}}
        @if($user->role === 'author')

        <div class="donations-card">

            <div class="donations-header">

                <div>
                    <h2 class="donations-title">Мои проекты</h2>
                    <p class="donations-subtitle">
                        Управление вашими инициативами
                    </p>
                </div>

                <button type="button"
                    onclick="openCreateModal()"
                    class="btn-create-project">

                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M8 3.33334V12.6667M3.33333 8H12.6667"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                    Создать проект
                </button>
            </div>

            <div class="donations-list">

                @forelse($user->projects ?? [] as $project)

                <div class="donation-item">

                    <div class="donation-left">

                        <div class="project-status-dot"></div>

                        <div>
                            <div class="donation-project">
                                {{ $project->title }}
                            </div>

                            <div class="donation-date">
                                Создан:
                                {{ $project->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="donation-meta">

                        <div class="project-status-badge">
                            {{ $project->status ?? 'Активен' }}
                        </div>

                        <div class="donation-amount">
                            {{ number_format($project->collected_amount ?? 0, 0, '.', ' ') }} ₽
                        </div>

                    </div>
                </div>

                @empty

                <div class="donations-empty">

                    <div class="empty-icon">
                        🚀
                    </div>

                    <h3>Пока нет проектов</h3>

                    <p>
                        Создайте первый проект и начните собирать поддержку
                    </p>

                    <button type="button"
                        onclick="openCreateModal()"
                        class="btn-create-project">

                        Создать проект
                    </button>
                </div>

                @endforelse

            </div>
        </div>

        @else

        {{-- DONATER --}}
        <div class="donations-card">

            <div class="donations-header">

                <div>
                    <h2 class="donations-title">История пожертвований</h2>
                    <p class="donations-subtitle">
                        Ваш вклад в развитие проектов
                    </p>
                </div>

                <div class="donations-total">
                    {{ number_format($totalAmount ?? 0, 0, '.', ' ') }} ₽
                </div>
            </div>

            <div class="donations-list">

                @forelse($donations ?? [] as $donation)

                <div class="donation-item">

                    <div class="donation-left">

                        <div class="donation-icon">
                            💖
                        </div>

                        <div>
                            <div class="donation-project">
                                {{ $donation->project->title ?? 'Проект удалён' }}
                            </div>

                            <div class="donation-date">
                                {{ $donation->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="donation-amount">
                        {{ number_format($donation->amount, 0, '.', ' ') }} ₽
                    </div>

                </div>

                @empty

                <div class="donations-empty">

                    <div class="empty-icon">
                        💙
                    </div>

                    <h3>Пока нет пожертвований</h3>

                    <p>
                        Поддержите первый проект и помогите сделать город лучше
                    </p>

                    <a href="{{ route('projects.index') }}"
                        class="donations-link">

                        Найти проекты →
                    </a>

                </div>

                @endforelse

            </div>
        </div>

        @endif

    </div>
</div>

{{-- TOAST --}}
<div id="toast" class="toast" style="display:none;">
    <span id="toastMessage"></span>
</div>

<script>
    function previewAvatar(input) {

        if (input.files && input.files[0]) {

            const reader = new FileReader();

            reader.onload = function(e) {

                const preview = document.getElementById('avatarPreview');

                if (preview.tagName === 'IMG') {

                    preview.src = e.target.result;

                } else {

                    preview.outerHTML = `
                    <img src="${e.target.result}"
                         alt="Preview"
                         class="profile-avatar"
                         id="avatarPreview">
                `;
                }
            }

            reader.readAsDataURL(input.files[0]);

            document.getElementById('profileForm').submit();
        }
    }

    function editName() {

        document.getElementById('nameDisplay').style.display = 'none';
        document.getElementById('editNameBtn').style.display = 'none';

        document.getElementById('nameInputWrapper').style.display = 'block';

        document.getElementById('nameInput').focus();
        document.getElementById('nameInput').select();
    }

    function saveName() {

        const input = document.getElementById('nameInput');

        const newName = input.value.trim();

        if (!newName) {

            showToast('Введите имя', 'error');

            return;
        }

        fetch("{{ route('profile.update') }}", {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },

                body: JSON.stringify({
                    _method: 'PATCH',
                    name: newName
                })

            })

            .then(response => response.json())

            .then(data => {

                if (data.success) {

                    document.getElementById('nameDisplay').textContent = data.name;

                    showToast('Имя обновлено');

                    cancelNameEdit();

                } else {

                    showToast(data.message || 'Ошибка', 'error');
                }
            })

            .catch(() => {

                showToast('Ошибка сервера', 'error');
            });
    }

    function cancelNameEdit() {

        document.getElementById('nameDisplay').style.display = 'block';

        document.getElementById('editNameBtn').style.display = 'flex';

        document.getElementById('nameInputWrapper').style.display = 'none';
    }

    function showToast(message, type = 'success') {

        const toast = document.getElementById('toast');

        const toastMessage = document.getElementById('toastMessage');

        toastMessage.textContent = message;

        toast.className = `toast ${type}`;

        toast.style.display = 'flex';

        setTimeout(() => {

            toast.style.opacity = '0';

            setTimeout(() => {

                toast.style.display = 'none';
                toast.style.opacity = '1';

            }, 300);

        }, 2500);
    }

    document.querySelectorAll('.alert').forEach(alert => {

        alert.addEventListener('click', () => {

            alert.style.opacity = '0';

            setTimeout(() => {

                alert.remove();

            }, 200);
        });


    });

    function openCreateModal() {

        const modal = document.getElementById('createProjectModal');

        if (!modal) return;

        modal.style.display = 'flex';

        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {

        const modal = document.getElementById(modalId);

        if (!modal) return;

        modal.style.display = 'none';

        document.body.style.overflow = '';
    }
</script>
@endsection