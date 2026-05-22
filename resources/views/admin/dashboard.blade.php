@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
<div class="admin-page">

    <div class="container">

        <div class="admin-header">

            <h1 class="admin-title">
                Панель администратора
            </h1>

            <div class="admin-actions">

                <a href="{{ route('admin.projects.create') }}" class="btn-add-project">
                    + Добавить проект
                </a>

                <a href="{{ route('admin.projects.index') }}" class="btn-manage-projects">
                    Управление проектами ({{ $projectsCount }})
                </a>

            </div>

        </div>

        <!-- Статистика -->
        <div class="admin-stats">
            <div class="admin-card">
                <h3>Пользователей</h3>
                <p class="stat-number">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="admin-card">
                <h3>Проектов</h3>
                <p class="stat-number">{{ class_exists('App\Models\Project') ? \App\Models\Project::count() : 0 }}</p>
            </div>
            <div class="admin-card">
                <h3>Пожертвований</h3>
                <p class="stat-number">{{ class_exists('App\Models\Donation') ? \App\Models\Donation::count() : 0 }}</p>
            </div>
        </div>

        <!-- Таблица пользователей -->
        <div class="admin-table-wrapper">
            <h2>Управление пользователями</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\User::latest()->take(15)->get() as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                            <span class="role-badge admin">
                                Админ
                            </span>

                            @elseif($user->role === 'author')
                            <span class="role-badge author">
                                Автор
                            </span>

                            @else
                            <span class="role-badge user">
                                Донатер
                            </span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.toggle-role', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-toggle-role">
                                    {{ $user->role === 'admin' ? 'Снять права' : 'Сделать админом' }}
                                </button>
                            </form>
                            @else
                            <span class="text-muted">Это вы</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">Пользователей пока нет</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

</div>

@endsection