<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $task->project->users()
            ->where('users.id', $user->id)
            ->exists()
            || $task->project->owner_id === $user->id;
    }

    public function create(User $user, Task $task): bool
    {
        if (!$task->project) {
            return false;
        }

        return $task->project->users()
            ->where('users.id', $user->id)
            ->exists()
            || $task->project->owner_id === $user->id;
    }


    public function update(User $user, Task $task): bool
    {
        return $this->view($user, $task);
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->project->owner_id === $user->id
            || $task->assigned_to === $user->id;
    }

    public function restore(User $user, Task $task): bool
    {
        return $this->view($user, $task);
    }


    public function forceDelete(User $user, Task $task): bool
    {
        return $this->view($user, $task);
    }
}
