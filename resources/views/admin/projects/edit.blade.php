@extends('layouts.app')

@section('title', 'Редактировать проект')

@section('content')
<div class="admin-page">
    <div class="container">

        <!-- Заголовок -->
        <div class="admin-header">
            <h1 class="admin-title">Редактировать проект</h1>
            <a href="{{ route('admin.projects.index') }}" class="btn-back">← Назад к списку</a>
        </div>

        <!-- Сообщения -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Форма редактирования -->
        <form action="{{ route('admin.projects.update', $project->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="project-form">
            @csrf
            @method('PATCH')

            <div class="form-grid">

                <!-- Основная информация -->
                <div class="form-section">
                    <h3>Основная информация</h3>

                    <div class="form-group">
                        <label for="title">Название проекта *</label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $project->title) }}" required>
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание *</label>
                        <textarea id="description" name="description" rows="5" required>{{ old('description', $project->description) }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="category">Категория *</label>
                        <select id="category" name="category" required>
                            <option value="">Выберите категорию</option>
                            @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->slug }}"
                                {{ old('category', $project->category) == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Локация -->
                <div class="form-section">
                    <h3>Локация</h3>

                    <div class="form-group">
                        <label for="city">Город *</label>
                        <input type="text" id="city" name="city"
                            value="{{ old('city', $project->city) }}" required>
                        @error('city') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="district">Район</label>
                        <input type="text" id="district" name="district"
                            value="{{ old('district', $project->district) }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="lat">Широта (lat)</label>
                            <input type="number" step="any" id="lat" name="lat"
                                value="{{ old('lat', $project->lat) }}">
                        </div>
                        <div class="form-group">
                            <label for="lng">Долгота (lng)</label>
                            <input type="number" step="any" id="lng" name="lng"
                                value="{{ old('lng', $project->lng) }}">
                        </div>
                    </div>
                </div>

                <!-- Финансы -->
                <div class="form-section">
                    <h3>Финансы</h3>

                    <div class="form-group">
                        <label for="goal_amount">Целевая сумма (₽) *</label>
                        <input type="number" id="goal_amount" name="goal_amount"
                            step="0.01" min="0"
                            value="{{ old('goal_amount', $project->goal_amount) }}" required>
                        @error('goal_amount') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="deadline">Дедлайн *</label>
                        <input type="date" id="deadline" name="deadline"
                            value="{{ old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '') }}" required>
                        @error('deadline') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Статус *</label>
                        <select id="status" name="status" required>
                            <option value="moderation" {{ old('status', $project->status) == 'moderation' ? 'selected' : '' }}>На модерации</option>
                            <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Активный</option>
                            <option value="voting" {{ old('status', $project->status) == 'voting' ? 'selected' : '' }}>На голосовании</option>
                            <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Завершён</option>
                        </select>
                    </div>
                </div>

                <!-- Изображение -->
                <div class="form-section">
                    <h3>Изображение</h3>

                    <div class="form-group">
                        <label for="image">Обложка проекта</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Макс. размер: 2МБ, форматы: JPG, PNG, GIF</small>
                        @error('image') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    @if($project->image)
                    <div class="image-preview">
                        <p style="margin-bottom: 8px; font-size: 13px; color: #64748B;">Текущее изображение:</p>
                        <img src="{{ Storage::url($project->image) }}" alt="Current">
                    </div>
                    @endif
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Сохранить изменения</button>
                <a href="{{ route('admin.projects.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>

    </div>
</div>
@endsection