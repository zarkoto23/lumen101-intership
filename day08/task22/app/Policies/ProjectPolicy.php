<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return $project->users()
            ->where('users.id', $user->id)
            ->exists()
            || $project->owner_id === $user->id;
    }


    public function update(User $user, Project $project): bool
    {
        return $project->owner_id === $user->id;
    }


    public function delete(User $user, Project $project): bool
    {
        return $project->owner_id === $user->id;
    }


    public function restore(User $user, Project $project): bool
    {
        return $project->owner_id === $user->id;
    }


    public function forceDelete(User $user, Project $project): bool
    {
        return $project->owner_id === $user->id;
    }
}
