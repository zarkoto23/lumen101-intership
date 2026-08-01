<?php

namespace App\Livewire;


use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Livewire\Component;



class EnrollmentForm extends Component
{


    public Course $course;



    public function enroll()
    {


        $user = Auth::user();



        if (!$user) {

            session()->flash(
                'error',
                'You must login first.'
            );

            return;

        }




        if (!$user->isStudent()) {


            session()->flash(
                'error',
                'Only students can enroll.'
            );


            return;

        }





        if ($this->course->status !== 'published') {


            session()->flash(
                'error',
                'Course is not available.'
            );


            return;

        }






        if (
            $this->course->end_date
            &&
            now()->gt($this->course->end_date)
        ) {


            session()->flash(
                'error',
                'Course has ended.'
            );


            return;

        }





        if (
            $this->course->maximum_students
            &&
            $this->course->enrollments()->count()
            >=
            $this->course->maximum_students
        ) {


            session()->flash(
                'error',
                'Course is full.'
            );


            return;

        }





        $exists = Enrollment::where(

            'course_id',

            $this->course->id

        )
        ->where(

            'student_id',

            $user->id

        )
        ->exists();





        if ($exists) {


            session()->flash(
                'error',
                'You are already enrolled.'
            );


            return;

        }






        DB::transaction(function () use ($user) {



            $enrollment = Enrollment::create([


                'course_id'=>$this->course->id,


                'student_id'=>$user->id,


                'status'=>'pending',


                'enrolled_at'=>now(),


            ]);





            Payment::create([


                'enrollment_id'=>$enrollment->id,


                'amount'=>$this->course->price,


                'status'=>'pending',


            ]);




        });







        session()->flash(

            'success',

            'Successfully enrolled.'

        );



    }





    public function render()
    {

        return view(
            'livewire.enrollment-form'
        );

    }


}