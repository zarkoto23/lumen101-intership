<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Certificate;

class CertificatePolicy
{
    public function view(User $user, Certificate $certificate): bool
    {
        return $user->isAdmin()
            ||
            (
                $user->isStudent()
                && $certificate->enrollment->student_id === $user->id
            )
            ||
            (
                $user->isInstructor()
                && $certificate->enrollment->course->instructor_id === $user->id
            );
    }


    public function create(User $user): bool
    {
        return $user->isAdmin();
    }


    public function update(User $user, Certificate $certificate): bool
    {
        return $user->isAdmin();
    }


    public function delete(User $user, Certificate $certificate): bool
    {
        return $user->isAdmin();
    }
}