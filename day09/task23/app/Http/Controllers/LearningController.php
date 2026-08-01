<?php

namespace App\Http\Controllers;


use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;



class LearningController extends Controller
{


    public function show(Enrollment $enrollment)
    {


        abort_unless(

            $enrollment->student_id === Auth::id(),

            403

        );




        $enrollment->load([

            'course.sections.lessons'

        ]);





        $totalLessons = $enrollment
            ->course
            ->sections
            ->sum(function($section){

                return $section
                    ->lessons
                    ->count();

            });






        $completedLessons = LessonProgress::where(

            'enrollment_id',

            $enrollment->id

        )
        ->where(

            'is_completed',

            true

        )
        ->count();






        $progress = $totalLessons > 0

            ? round(
                ($completedLessons / $totalLessons) * 100
            )

            : 0;





        return view(

            'learning.show',

            compact(
                'enrollment',
                'progress'
            )

        );


    }





    public function complete($lesson)
    {


        $enrollmentId = request('enrollment_id');



        LessonProgress::updateOrCreate(

            [

                'lesson_id'=>$lesson,

                'enrollment_id'=>$enrollmentId

            ],


            [

                'is_completed'=>true,

                'completed_at'=>now()

            ]

        );



        return back();

    }


}