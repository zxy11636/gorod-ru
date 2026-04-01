<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        
        $projects = Project::where('status', 'active')
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);
        
        $categories = Category::all();
        
        return view('projects.index', compact('projects', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required|exists:categories,slug',
            'city' => 'required',
            'district' => 'nullable',
            'goal_amount' => 'required|numeric|min:1000',
            'deadline' => 'required|date|after:today',
            'image' => 'nullable|image|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'moderation'; 

        $project = Project::create($validated);
        
        return redirect()->route('projects.show', $project)
                        ->with('success', 'Проект создан и отправлен на модерацию!');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $categories = Category::all();
        return view('projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required|exists:categories,slug',
            'city' => 'required',
            'district' => 'nullable',
            'goal_amount' => 'required|numeric|min:1000',
            'deadline' => 'required|date|after:today',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $project->update($validated);
        
        return redirect()->route('projects.show', $project)
                        ->with('success', 'Проект обновлен!');
    }


    public function destroy(Project $project)
    {
        $project->delete();
        
        return redirect()->route('projects.index')
                        ->with('success', 'Проект удален!');
    }
    

    public function byCategory(Category $category)
    {
        $projects = Project::where('category', $category->slug)
                        ->where('status', 'active')
                        ->paginate(12);
        
        return view('projects.index', compact('projects', 'category'));
    }
}