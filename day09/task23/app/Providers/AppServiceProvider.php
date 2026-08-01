<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;

use App\Policies\CoursePolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\AssignmentSubmissionPolicy;
use App\Policies\CertificatePolicy;


class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }


    public function boot(): void
    {
        Gate::policy(
            Course::class,
            CoursePolicy::class
        );


        Gate::policy(
            Enrollment::class,
            EnrollmentPolicy::class
        );


        Gate::policy(
            AssignmentSubmission::class,
            AssignmentSubmissionPolicy::class
        );


        Gate::policy(
            Certificate::class,
            CertificatePolicy::class
        );
    }
}