<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Livewire\StudentDashboard;
use App\Livewire\CourseLearning;



Route::get('/', [CourseController::class, 'index'])
    ->name('home');



Route::get('/courses/{course}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::get('/student/dashboard', StudentDashboard::class)
    ->middleware('auth')
    ->name('student.dashboard');




Route::get(
    '/courses/{course}/learn',
    CourseLearning::class
)

    ->middleware('auth')

    ->name('courses.learn');



Route::middleware('auth')->group(function () {


    Route::post(
        '/courses/{course}/enroll',
        [EnrollmentController::class, 'store']
    )
        ->name('courses.enroll');



    Route::get(
        '/learning/{enrollment}',
        [LearningController::class, 'show']
    )
        ->name('learning.show');



    Route::post(
        '/lesson/{lesson}/complete',
        [LearningController::class, 'complete']
    )
        ->name('lesson.complete');



    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )
        ->middleware('verified')
        ->name('dashboard');



    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )
        ->name('profile.edit');



    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )
        ->name('profile.update');



    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )
        ->name('profile.destroy');
});



require __DIR__ . '/auth.php';
