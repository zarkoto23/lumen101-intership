<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseRegistration;

class CourseController extends Controller
{
  public function create()
  {
    return view('courses.register');
  }

  public function store(Request $request)
  {
    $request->validate([
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required|email',
      'age' => 'required|integer|between:16,70',
      'specialty' => 'required',
      'course' => 'required',
      'study_form' => 'required',
    ]);

    CourseRegistration::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'age' => $request->age,
      'specialty' => $request->specialty,
      'course' => $request->course,
      'study_form' => $request->study_form,
    ]);

    return redirect('/courses/registrations')
      ->with('success', 'Успешна регистрация!');
  }

  public function index()
  {
    $registrations = CourseRegistration::all();

    return view('courses.registrations', compact('registrations'));
  }
}
