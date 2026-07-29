<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Course;

class DashboardController extends Controller
{
  public function index()
  {
    $teachersCount = Teacher::count();

    $coursesCount = Course::count();

    $averagePrice = Course::avg('price');

    $mostExpensiveCourse = Course::orderBy('price', 'desc')
      ->first();

    $teacherWithMostCourses = Teacher::withCount('courses')
      ->orderBy('courses_count', 'desc')
      ->first();


    return view('dashboard', compact(
      'teachersCount',
      'coursesCount',
      'averagePrice',
      'mostExpensiveCourse',
      'teacherWithMostCourses'
    ));
  }
}
