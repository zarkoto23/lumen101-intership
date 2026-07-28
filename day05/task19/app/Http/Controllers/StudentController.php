<?php

namespace App\Http\Controllers;


class StudentController extends Controller
{
    public function show()
    {
        $firstName = 'Иван';
        $lastName = 'Иванов';
        $age = 22;
        $specialty = 'Софтуерно инженерство';
        $course = 3;
        $email = 'ivan@example.com';

        return view('student', compact(
            'firstName',
            'lastName',
            'age',
            'specialty',
            'course',
            'email'
        ));
    }
}
