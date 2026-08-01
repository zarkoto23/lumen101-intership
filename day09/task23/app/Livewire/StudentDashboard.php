<?php

namespace App\Livewire;


use App\Models\Enrollment;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;



class StudentDashboard extends Component
{


    public function render()
    {


        $enrollments = Enrollment::where(
                'student_id',
                Auth::id()
            )

            ->with([
                'course',
                'payment',
                'certificate'
            ])

            ->get();




        return view(
            'livewire.student-dashboard',
            compact('enrollments')
        );

    }


}