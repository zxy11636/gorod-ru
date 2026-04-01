<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularProjects = Project::where('status', 'active')
                                ->orderBy('current_amount', 'desc')
                                ->limit(6)
                                ->get();

        $newProjects = Project::where('status', 'active')
                            ->orderBy('created_at', 'desc')
                            ->limit(6)
                            ->get();

        $endingSoon = Project::where('status', 'active')
                            ->where('deadline', '>', now())
                            ->orderBy('deadline', 'asc')
                            ->limit(6)
                            ->get();
        
        $categories = Category::all();

        $totalProjects = Project::where('status', 'active')->count();
        $totalDonations = Project::sum('current_amount');
        $totalDonors = \App\Models\Donation::where('status', 'completed')
                                        ->distinct('user_id')
                                        ->count('user_id');
        
        return view('home', compact(
            'popularProjects', 
            'newProjects', 
            'endingSoon', 
            'categories',
            'totalProjects',
            'totalDonations',
            'totalDonors'
        ));
    }
}