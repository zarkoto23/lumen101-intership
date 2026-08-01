<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;


class EnrollmentController extends Controller
{


    public function store(Course $course)
    {


        $user = Auth::user();



        abort_unless(
            $user &&
            $user->role === 'student',
            403
        );



        $alreadyExists = Enrollment::where(

            'course_id',
            $course->id

        )
        ->where(

            'student_id',
            $user->id

        )
        ->exists();




        if($alreadyExists)
        {

            return back()
                ->with(
                    'error',
                    'Already enrolled'
                );

        }




        Enrollment::create([

            'course_id'=>$course->id,

            'student_id'=>$user->id,

            'status'=>'active',

            'enrolled_at'=>now()

        ]);




        return back()

            ->with(
                'success',
                'Enrollment completed'
            );


    }

}