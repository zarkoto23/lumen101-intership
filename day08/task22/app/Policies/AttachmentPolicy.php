<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;

class AttachmentPolicy
{
    public function delete(User $user, Attachment $attachment): bool
    {
        return $attachment->user_id === $user->id;
    }


    public function view(User $user, Attachment $attachment): bool
    {
        return $attachment->task->project->users()
            ->where('users.id', $user->id)
            ->exists()
            || $attachment->task->project->owner_id === $user->id;
    }
}