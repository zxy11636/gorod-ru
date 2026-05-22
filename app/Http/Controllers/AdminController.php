<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Главная админки
    public function index()
    {
        $usersCount = User::count();
        $projectsCount = Project::count();
        $donationsCount = class_exists('App\Models\Donation') ? \App\Models\Donation::count() : 0;
        
        $users = User::latest()->take(15)->get();
        
        return view('admin.dashboard', compact('usersCount', 'projectsCount', 'donationsCount', 'users'));
    }

    // Переключение роли пользователя
    public function toggleRole(Request $request, User $user)
{
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Нельзя изменить свою роль');
    }

    // Логика переключения
    $roles = ['donor', 'author', 'admin'];
    $currentIndex = array_search($user->role, $roles);
    
    // Переключаем на следующую роль
    $nextIndex = ($currentIndex + 1) % count($roles);
    $user->role = $roles[$nextIndex];
    $user->save();

    return back()->with('success', "Роль изменена на {$user->role}");
}

    // 🔹 Страница создания проекта
    public function createProject()
    {
        return view('admin.projects.create');
    }

    // 🔹 Сохранение проекта
    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'city' => 'required|string',
            'district' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:pending,moderation,active,voting,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }

        // Создаём проект от имени админа
        $validated['user_id'] = auth()->id();
        $validated['current_amount'] = 0;

        Project::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Проект создан!');
    }

    // 🔹 Список проектов для управления
    public function listProjects(Request $request)
{
    $query = Project::with('author')->latest();

    // Если в URL есть ?status=pending, фильтруем
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    $projects = $query->paginate(20);
    return view('admin.projects.index', compact('projects'));
}

    // 🔹 Редактирование проекта
    public function editProject(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    // 🔹 Обновление проекта
    public function updateProject(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'city' => 'required|string',
            'district' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,moderation,active,voting,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }

        $project->update($validated);

        return back()->with('success', 'Проект обновлён!');
    }

    // 🔹 Удаление проекта
    public function deleteProject(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();

        return back()->with('success', 'Проект удалён');
    }
}