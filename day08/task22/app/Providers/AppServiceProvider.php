<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Attachment;

use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\CommentPolicy;
use App\Policies\AttachmentPolicy;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    Gate::policy(Project::class, ProjectPolicy::class);
    Gate::policy(Task::class, TaskPolicy::class);
    Gate::policy(Comment::class, CommentPolicy::class);
    Gate::policy(Attachment::class, AttachmentPolicy::class);


    Route::bind('project', function ($value) {
        return Project::withTrashed()
            ->findOrFail($value);
    });
}
}
