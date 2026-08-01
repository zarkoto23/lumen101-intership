<?php

namespace App\Livewire;


use App\Models\Course;
use App\Models\LessonProgress;


use Illuminate\Support\Facades\Auth;


use Livewire\Component;



class CourseLearning extends Component
{


    public Course $course;


    public $currentLesson;



    public function mount()
    {


        $this->currentLesson = $this->course

            ->sections()

            ->with('lessons')

            ->first()

            ?->lessons

            ->first();


    }





    public function completeLesson($lessonId)
    {


        $enrollment = $this->course

            ->enrollments()

            ->where(
                'student_id',
                Auth::id()
            )

            ->where(
                'status',
                'active'
            )

            ->first();




        if (!$enrollment) {

            abort(403);

        }





        LessonProgress::updateOrCreate(

            [

                'enrollment_id'=>$enrollment->id,

                'lesson_id'=>$lessonId,

            ],

            [

                'is_completed'=>true,

                'completed_at'=>now(),

            ]

        );



    }






    public function render()
    {


        $sections = $this->course

            ->sections()

            ->with('lessons')

            ->orderBy('position')

            ->get();




        $enrollment = $this->course

            ->enrollments()

            ->where(
                'student_id',
                Auth::id()
            )

            ->first();




        $completed = 0;


        $total = 0;



        if($enrollment){


            $total = $this->course

                ->sections()

                ->withCount('lessons')

                ->get()

                ->sum('lessons_count');



            $completed = LessonProgress::where(

                'enrollment_id',

                $enrollment->id

            )

            ->where(

                'is_completed',

                true

            )

            ->count();


        }





        $progress = $total > 0

            ? round(($completed / $total) * 100)

            : 0;





        return view(

            'livewire.course-learning',

            compact(

                'sections',

                'progress'

            )

        );


    }


}