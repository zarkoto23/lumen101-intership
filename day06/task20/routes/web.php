<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return redirect('/courses/register');
});

Route::get('/courses/register', [CourseController::class, 'create']);

Route::post('/courses/register', [CourseController::class, 'store']);

Route::get('/courses/registrations', [CourseController::class, 'index']);
