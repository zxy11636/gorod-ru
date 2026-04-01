<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('projects', ProjectController::class);

Route::view('/map', 'map')->name('map');

Route::view('/how-it-works', 'how-it-works')->name('how-it-works');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');