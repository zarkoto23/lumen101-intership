<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Comment $comment): bool
    {
        return $comment->task->project->users()
            ->where('users.id', $user->id)
            ->exists()
            || $comment->task->project->owner_id === $user->id;
    }


    public function create(User $user, Task $task): bool
    {
        return $task->project->users()
            ->where('users.id', $user->id)
            ->exists()
            || $task->project->owner_id === $user->id;
    }


    public function update(User $user, Comment $comment): bool
    {
        return false;
    }


    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }


    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }


    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}