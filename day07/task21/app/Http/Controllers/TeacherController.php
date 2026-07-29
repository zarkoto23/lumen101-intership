<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('courses')->paginate(5);

        return view('teachers.index', compact('teachers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:teachers',
            'specialization' => 'required',
        ]);

        Teacher::create($validated);

        return redirect('/teachers')
            ->with('success', 'Teacher created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('courses');

        return view('teachers.show', compact('teacher'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'specialization' => 'required',
        ]);

        $teacher->update($validated);

        return redirect('/teachers')
            ->with('success', 'Teacher updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->courses()->exists()) {
            return redirect('/teachers')
                ->with('error', 'Cannot delete teacher with assigned courses.');
        }

        $teacher->delete();

        return redirect('/teachers')
            ->with('success', 'Teacher deleted successfully.');
    }
}