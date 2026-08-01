<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enrollment;

class EnrollmentPolicy
{

    public function view(User $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin()
            ||
            (
                $user->isStudent()
                && $enrollment->student_id === $user->id
            )
            ||
            (
                $user->isInstructor()
                && $enrollment->course->instructor_id === $user->id
            );
    }


public function create(User $user): bool
{
    return $user->isAdmin()
        || $user->isStudent();
}

    public function update(User $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Enrollment $enrollment): bool
{
    return $user->isAdmin();
}
}