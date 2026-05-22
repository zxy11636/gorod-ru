<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    /**
     * Список всех проектов с фильтрацией
     */
    public function index(Request $request)
    {
        $query = Project::query();

        // Фильтр по категории (по slug)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Поиск по названию
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $projects = $query->latest()->paginate(12);

        // 🔹 Получаем категории из БД
        $categories = Category::all()->mapWithKeys(function($category) {
            return [
                $category->slug => [
                    'label' => $category->name,
                    'count' => Project::where('category', $category->slug)->count()
                ]
            ];
        });

        // Статусы
        $statuses = [
            'active' => ['label' => 'Активные', 'count' => Project::where('status', 'active')->count()],
            'voting' => ['label' => 'На голосовании', 'count' => Project::where('status', 'voting')->count()],
            'completed' => ['label' => 'Реализованные', 'count' => Project::where('status', 'completed')->count()],
        ];

        return view('projects.index', compact('projects', 'categories', 'statuses'));
    }

    /**
     * Страница одного проекта
     */
    public function show(Project $project)
{
    // Проверка: если проект не активен и пользователь не админ — 404
    if (!in_array($project->status, ['active', 'voting', 'completed']) && !auth()->user()?->isAdmin()) {
        abort(404);
    }
    
    // Последние 5 пожертвований для этого проекта (если модель есть)
    $recentDonations = class_exists('App\Models\Donation') 
        ? \App\Models\Donation::where('project_id', $project->id)
            ->where('status', 'completed')
            ->with('user')
            ->latest()
            ->take(5)
            ->get()
        : collect();
        $comments = Comment::where('project_id', $project->id)
        ->whereNull('parent_id') // Только корневые
        ->with(['user', 'replies.user'])
        ->latest()
        ->paginate(10);

    // Последние пожертвования
    $recentDonations = class_exists('App\Models\Donation') 
        ? \App\Models\Donation::where('project_id', $project->id)
            ->where('status', 'completed')
            ->with('user')
            ->latest()
            ->take(5)
            ->get()
        : collect();

    return view('projects.show', compact('project', 'recentDonations', 'comments'));
}
}