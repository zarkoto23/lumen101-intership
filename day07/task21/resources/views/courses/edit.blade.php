<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Course</title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <nav>
        <a href="/dashboard">Dashboard</a> |
        <a href="/teachers">Teachers</a> |
        <a href="/courses">Courses</a>
    </nav>

    <hr>


    <h1>Edit Course</h1>

    <form method="POST" action="/courses/{{ $course->id }}">

        @csrf
        @method('PUT')


        <label>
            Teacher
        </label>

        <select name="teacher_id">

            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->first_name }}
                    {{ $teacher->last_name }}
                </option>
            @endforeach

        </select>


        <input type="text" name="name" value="{{ $course->name }}">


        <textarea name="description">{{ $course->description }}</textarea>


        <input type="number" name="duration" value="{{ $course->duration }}">


        <input type="number" step="0.01" name="price" value="{{ $course->price }}">


        <button type="submit">
            Update
        </button>

    </form>

</body>

</html>
