<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;

// Projects
Route::get('/projects',       [ProjectController::class, 'index']);
Route::get('/projects/{slug}',[ProjectController::class, 'show']);

// Blog
Route::get('/posts',          [BlogController::class, 'index']);
Route::get('/posts/{slug}',   [BlogController::class, 'show']);

// Team
Route::get('/team',           [BlogController::class, 'team']);

// Contact
Route::post('/contact',       [ContactController::class, 'store']);
