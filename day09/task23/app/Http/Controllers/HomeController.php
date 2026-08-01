<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'published')
            ->with(['category', 'instructor'])
            ->latest()
            ->paginate(9);

        return view('home', compact('courses'));
    }
}