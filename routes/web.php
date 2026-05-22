<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DonationController; // 🔹 Добавили контроллер проектов
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return redirect('/'); // Или redirect('/')->with('showLoginModal', true); если хочешь сразу открывать модалку
})->name('login');

// === 🔹 AJAX-маршруты для модалки (должны быть ПЕРЕД auth.php) ===
Route::post('/ajax/register', [AuthController::class, 'register'])->name('ajax.register');
Route::post('/ajax/login', [AuthController::class, 'login'])->name('ajax.login');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');

// 🔹 Технический маршрут, чтобы Laravel не падал с ошибкой Route [login] not defined.
// Если гость попытается зайти на /profile или отправить форму доната в обход JS-модалки, 
// его просто мягко вернет на главную страницу.
Route::get('/login', function () {
    return redirect('/');
})->name('login');

// Дашборд (стандартный Laravel)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Профиль
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/projects', [App\Http\Controllers\UserProjectController::class, 'store'])->name('projects.store');
});

// 🔹 Админка: простой маршрут (можно удалить, если используешь группу ниже)
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'check.role'])
    ->name('admin.dashboard');

// 🔹 Админка: группа маршрутов с префиксом и правами
Route::middleware(['auth', 'check.role'])->prefix('admin')->name('admin.')->group(function () {
    
    // Дашборд админки
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Управление пользователями
    Route::patch('/users/{user}/toggle-role', [AdminController::class, 'toggleRole'])->name('toggle-role');
    
    // Управление проектами
    Route::get('/projects', [AdminController::class, 'listProjects'])->name('projects.index');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::patch('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.destroy');
    Route::get('/admin/projects/pending', [AdminController::class, 'pendingProjects'])->name('admin.projects.pending');
    Route::post('/admin/projects/{project}/approve', [AdminController::class, 'approveProject'])->name('admin.projects.approve');
});

Route::middleware('auth')->group(function () {
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
});
use App\Http\Controllers\CommentController;

// ...

// 🔹 Комментарии (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/vote', [CommentController::class, 'vote'])->name('comments.vote');
});

Route::get('/how-it-works', function () {
    return view('pages.how-it-works');
})->name('how-it-works');
