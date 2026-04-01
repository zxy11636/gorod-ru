@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="max-w-7xl mx-auto px-4">

    <div class="text-center py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Меняем город к лучшему вместе
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Поддерживайте проекты благоустройства или предлагайте свои идеи
        </p>
        <div class="space-x-4">
            <a href="/projects" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700">
                Найти проект
            </a>
            <a href="/projects/create" class="bg-green-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-700">
                Предложить идею
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 my-12">
        <div class="text-center p-6 bg-white rounded-lg shadow">
            <div class="text-3xl font-bold text-blue-600">{{ $totalProjects }}</div>
            <div class="text-gray-600">активных проектов</div>
        </div>
        <div class="text-center p-6 bg-white rounded-lg shadow">
            <div class="text-3xl font-bold text-green-600">{{ number_format($totalDonations) }} ₽</div>
            <div class="text-gray-600">собрано всего</div>
        </div>
        <div class="text-center p-6 bg-white rounded-lg shadow">
            <div class="text-3xl font-bold text-purple-600">{{ $totalDonors }}</div>
            <div class="text-gray-600">поддержавших</div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6">Категории проектов</h2>
    <div class="grid grid-cols-5 gap-4 mb-12">
        @foreach($categories as $category)
        <a href="/category/{{ $category->slug }}" class="bg-white p-4 rounded-lg shadow text-center hover:shadow-md transition">
            <div class="font-medium">{{ $category->name }}</div>
        </a>
        @endforeach
    </div>

    <h2 class="text-2xl font-bold mb-6">Популярные проекты</h2>
    <div class="grid grid-cols-3 gap-6 mb-12">
        @foreach($popularProjects as $project)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">{{ $project->title }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                <div class="mb-2">
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ number_format($project->current_amount) }} ₽</span>
                        <span>из {{ number_format($project->goal_amount) }} ₽</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->getProgressPercentage() }}%"></div>
                    </div>
                </div>
                <a href="/projects/{{ $project->id }}" class="text-blue-600 hover:underline">Подробнее →</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection