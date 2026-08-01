<?php

namespace App\Http\Controllers;

use App\Models\Course;


class CourseController extends Controller
{


    public function index()
    {

        $courses = Course::query()

            ->where('status','published')

            ->with([
                'category',
                'instructor'
            ])

            ->latest()

            ->paginate(9);



        return view(
            'home',
            compact('courses')
        );

    }




    public function show(Course $course)
    {

        abort_if(
            $course->status !== 'published',
            404
        );



        $course->load([

            'category',

            'instructor',

            'sections.lessons'

        ]);



        return view(
            'courses.show',
            compact('course')
        );

    }

}