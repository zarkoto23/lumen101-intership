<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\User;
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
                'Courses',
                Course::count()
            )
            ->description('Total courses'),


            Stat::make(
                'Students',
                User::where(
                    'role',
                    'student'
                )->count()
            )
            ->description('Registered students'),


            Stat::make(
                'Enrollments',
                Enrollment::count()
            )
            ->description('Total enrollments'),


            Stat::make(
                'Revenue',
                Payment::where(
                    'status',
                    'paid'
                )
                ->sum('amount') . ' EUR'
            )
            ->description('Paid payments'),

        ];
    }
}