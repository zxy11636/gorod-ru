<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProjectController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'goal_amount' => 'required|numeric|min:1000',
        'category'    => 'required|string',
        'district'    => 'required|string|max:255',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $project = new Project($validated);
    $project->user_id = Auth::id(); 
    $project->status  = 'pending';   
    $project->current_amount = 0.00; 

    $project->city = 'Воронеж';
    $project->deadline = now()->addMonths(3);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('projects', 'public');
        $project->image = $path;
    }

    $project->save();

    return redirect()->route('profile.edit')->with('success', 'Проект успешно отправлен на модерацию!');
}
}