<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class AcademyStats extends BaseWidget
{

    protected function getStats(): array
    {
        return [

            Stat::make(
                'Students',
                User::where('role', 'student')->count()
            ),


            Stat::make(
                'Instructors',
                User::where('role', 'instructor')->count()
            ),


            Stat::make(
                'Published Courses',
                Course::where('status', 'published')->count()
            ),


            Stat::make(
                'Enrollments',
                Enrollment::count()
            ),


            Stat::make(
                'Revenue',
                Payment::where('status', 'paid')
                    ->sum('amount') . ' EUR'
            ),

        ];
    }

}