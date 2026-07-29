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



    h1>{{ $course->name }}</h1>

    <p>
        Teacher:
        {{ $course->teacher->first_name }}
        {{ $course->teacher->last_name }}
    </p>

    <p>
        Description:
        {{ $course->description }}
    </p>

    <p>
        Duration:
        {{ $course->duration }}
    </p>

    <p>
        Price:
        {{ $course->price }}
    </p>
</body>

</html>
