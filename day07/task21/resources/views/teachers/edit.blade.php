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


    <h1>Edit Teacher</h1>

    <form method="POST" action="/teachers/{{ $teacher->id }}">

        @csrf
        @method('PUT')

        <input type="text" name="first_name" value="{{ $teacher->first_name }}">

        <input type="text" name="last_name" value="{{ $teacher->last_name }}">

        <input type="email" name="email" value="{{ $teacher->email }}">

        <input type="text" name="specialization" value="{{ $teacher->specialization }}">

        <button type="submit">
            Update
        </button>

    </form>

</body>

</html>
