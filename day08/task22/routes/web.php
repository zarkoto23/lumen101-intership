<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DashboardController;
use App\Models\Project;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::patch('/projects/{project}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');

    Route::get('/projects/deleted', [ProjectController::class, 'deleted'])
        ->name('projects.deleted');

    Route::resource('projects', ProjectController::class);

    Route::resource('tasks', TaskController::class);

    Route::patch('/tasks/{task}/restore', [TaskController::class, 'restore'])
        ->name('tasks.restore');

    Route::get('/tasks/deleted', [TaskController::class, 'deleted'])
        ->name('tasks.deleted');

    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::post('/tasks/{task}/attachments', [AttachmentController::class, 'store'])
        ->name('attachments.store');

    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');

    Route::post('/projects/{project}/users', [ProjectController::class, 'addUser'])
        ->name('projects.users.add');

    Route::delete('/projects/{project}/users/{user}', [ProjectController::class, 'removeUser'])
        ->name('projects.users.remove');

    Route::patch('/projects/{project}/users/{user}/role', [ProjectController::class, 'updateUserRole'])
        ->name('projects.users.role');

    Route::get('/projects/{project}/users', function (Project $project) {

        abort_unless(
            auth()->user()->can('view', $project),
            403
        );

        return $project->users;
    })->name('projects.users');

    Route::get('/kanban', [TaskController::class, 'kanban'])
        ->name('tasks.kanban');
});

require __DIR__ . '/auth.php';
