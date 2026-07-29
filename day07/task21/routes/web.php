<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::resource('teachers', TeacherController::class);

Route::resource('courses', CourseController::class);

Route::get('/dashboard', [DashboardController::class, 'index']);
