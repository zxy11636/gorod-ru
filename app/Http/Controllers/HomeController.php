<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Проекты для слайдера (активные)
        $activeProjects = Project::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        // Завершенные проекты
        $completedProjects = Project::where('status', 'completed')
            ->latest()
            ->take(2)
            ->get();

        // Общее количество завершенных
        $totalCompleted = Project::where('status', 'completed')->count();

        return view('home', compact(
            'activeProjects',
            'completedProjects',
            'totalCompleted'
        ));
    }
}