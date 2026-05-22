@extends('layouts.app')

@section('title', 'Добавить проект')

@section('content')
<div class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1 class="admin-title">Добавить проект</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← Назад</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="project-form">
            @csrf

            <div class="form-grid">
                <!-- Основная информация -->
                <div class="form-section">
                    <h3>Основная информация</h3>
                    
                    <div class="form-group">
                        <label for="title">Название проекта *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание *</label>
                        <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="category">Категория *</label>
                        <select id="category" name="category" required>
                            <option value="">Выберите категорию</option>
                            <option value="parks" {{ old('category') == 'parks' ? 'selected' : '' }}>Парки и скверы</option>
                            <option value="roads" {{ old('category') == 'roads' ? 'selected' : '' }}>Дороги и тротуары</option>
                            <option value="culture" {{ old('category') == 'culture' ? 'selected' : '' }}>Культура</option>
                            <option value="education" {{ old('category') == 'education' ? 'selected' : '' }}>Образование</option>
                            <option value="sport" {{ old('category') == 'sport' ? 'selected' : '' }}>Спорт</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Другое</option>
                        </select>
                        @error('category') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Локация -->
                <div class="form-section">
                    <h3>Локация</h3>
                    
                    <div class="form-group">
                        <label for="city">Город *</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="district">Район</label>
                        <input type="text" id="district" name="district" value="{{ old('district') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="lat">Широта (lat)</label>
                            <input type="number" step="any" id="lat" name="lat" value="{{ old('lat') }}">
                        </div>
                        <div class="form-group">
                            <label for="lng">Долгота (lng)</label>
                            <input type="number" step="any" id="lng" name="lng" value="{{ old('lng') }}">
                        </div>
                    </div>
                </div>

                <!-- Финансы -->
                <div class="form-section">
                    <h3>Финансы</h3>
                    
                    <div class="form-group">
                        <label for="goal_amount">Целевая сумма (₽) *</label>
                        <input type="number" id="goal_amount" name="goal_amount" step="0.01" min="0" value="{{ old('goal_amount') }}" required>
                        @error('goal_amount') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="deadline">Дедлайн *</label>
                        <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                        @error('deadline') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Статус *</label>
                        <select id="status" name="status" required>
                            <option value="moderation" {{ old('status') == 'moderation' ? 'selected' : '' }}>На модерации</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Активный</option>
                            <option value="voting" {{ old('status') == 'voting' ? 'selected' : '' }}>Голосование</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Завершён</option>
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

                    @if(old('image'))
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . old('image')) }}" alt="Preview">
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Создать проект</button>
                <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection