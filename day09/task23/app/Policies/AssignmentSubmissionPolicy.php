<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AssignmentSubmission;

class AssignmentSubmissionPolicy
{
    public function view(User $user, AssignmentSubmission $submission): bool
    {
        return $user->isAdmin()
            ||
            (
                $user->isStudent()
                && $submission->student_id === $user->id
            )
            ||
            (
                $user->isInstructor()
                && $submission->assignment->course->instructor_id === $user->id
            );
    }


    public function create(User $user): bool
    {
        return $user->isStudent();
    }


    public function update(User $user, AssignmentSubmission $submission): bool
    {
        return $user->isAdmin()
            ||
            (
                $user->isInstructor()
                && $submission->assignment->course->instructor_id === $user->id
            );
    }


    public function delete(User $user, AssignmentSubmission $submission): bool
    {
        return $user->isAdmin();
    }
}