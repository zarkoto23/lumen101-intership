<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;

class CourseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $query = Course::with('teacher');


    if ($request->filled('search')) {
      $query->where('name', 'like', '%' . $request->search . '%');
    }


    if ($request->filled('teacher_id')) {
      $query->where('teacher_id', $request->teacher_id);
    }


    if ($request->filled('sort')) {

      if ($request->sort == 'asc') {
        $query->orderBy('price', 'asc');
      }

      if ($request->sort == 'desc') {
        $query->orderBy('price', 'desc');
      }
    }


    $courses = $query->paginate(5);

    $teachers = Teacher::all();


    return view('courses.index', compact(
      'courses',
      'teachers'
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $teachers = Teacher::all();

    return view('courses.create', compact('teachers'));
  }
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'teacher_id' => 'required|exists:teachers,id',
      'name' => 'required',
      'description' => 'required',
      'duration' => 'required|integer',
      'price' => 'required|numeric',
    ]);

    Course::create($validated);

    return redirect('/courses')
      ->with('success', 'Course created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Course $course)
  {
    $course->load('teacher');

    return view('courses.show', compact('course'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Course $course)
  {
    $teachers = Teacher::all();

    return view('courses.edit', compact('course', 'teachers'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Course $course)
  {
    $validated = $request->validate([
      'teacher_id' => 'required|exists:teachers,id',
      'name' => 'required',
      'description' => 'required',
      'duration' => 'required|integer',
      'price' => 'required|numeric',
    ]);

    $course->update($validated);

    return redirect('/courses')
      ->with('success', 'Course updated successfully.');
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Course $course)
  {
    $course->delete();

    return redirect('/courses')
      ->with('success', 'Course deleted successfully.');
  }
}
