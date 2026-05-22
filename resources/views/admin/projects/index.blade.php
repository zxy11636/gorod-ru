@extends('layouts.app')

@section('title', 'Управление проектами')

@section('content')
<div class="admin-page">
    <div class="container">

        <!-- Заголовок -->
        <div class="admin-header">
            <h1 class="admin-title">Управление проектами</h1>
            <a href="{{ route('admin.projects.create') }}" class="btn-add-project">
                + Добавить проект
            </a>
        </div>

        <!-- Сообщения -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Вкладки фильтрации -->
        <div class="project-tabs" style="margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; display: flex; gap: 20px;">
            <a href="{{ route('admin.projects.index') }}"
                style="padding: 10px 0; border-bottom: 2px solid {{ request()->status == '' ? '#3b82f6' : 'transparent' }}; color: {{ request()->status == '' ? '#3b82f6' : '#6b7280' }}; text-decoration: none; font-weight: 600;">
                Все проекты
            </a>
            <a href="{{ route('admin.projects.index', ['status' => 'pending']) }}"
                style="padding: 10px 0; border-bottom: 2px solid {{ request()->status == 'pending' ? '#f59e0b' : 'transparent' }}; color: {{ request()->status == 'pending' ? '#f59e0b' : '#6b7280' }}; text-decoration: none; font-weight: 600;">
                На модерации ({{ \App\Models\Project::where('status', 'pending')->count() }})
            </a>
            <a href="{{ route('admin.projects.index', ['status' => 'active']) }}"
                style="padding: 10px 0; border-bottom: 2px solid {{ request()->status == 'active' ? '#10b981' : 'transparent' }}; color: {{ request()->status == 'active' ? '#10b981' : '#6b7280' }}; text-decoration: none; font-weight: 600;">
                Опубликованные
            </a>
        </div>

        <!-- Таблица проектов -->
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Город</th>
                        <th>Сбор</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>
                            @if($project->image)
                            <img src="{{ Storage::url($project->image) }}"
                                alt="{{ $project->title }}"
                                class="table-thumb">
                            @else
                            <span class="table-no-image">Нет</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($project->title, 40) }}</td>
                        <td>
                            <span class="badge badge-category">{{ $project->category }}</span>
                        </td>
                        <td>{{ $project->city }}</td>
                        <td>
                            <strong>{{ $project->formatted_current }}</strong>
                            <small class="text-muted">/ {{ $project->formatted_goal }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $project->status }}">
                                {{ $project->status === 'active' ? 'Активен' : ($project->status === 'voting' ? 'Голосование' : ($project->status === 'completed' ? 'Завершён' : 'Модерация')) }}
                            </span>
                        </td>
                        <td class="table-actions">
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn-action btn-edit" title="Редактировать">
                                ✎
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить проект?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Удалить">
                                    🗑
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6">
                            <p class="text-muted">Проектов пока нет</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Пагинация -->
            @if($projects->hasPages())
            <div class="admin-pagination">
                {{ $projects->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection