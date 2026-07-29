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


    <h2>Courses</h2>

    @if ($teacher->courses->count())

        @foreach ($teacher->courses as $course)
            <div>
                <h3>
                    {{ $course->name }}
                </h3>

                <p>
                    Duration: {{ $course->duration }}
                </p>

                <p>
                    Price: {{ $course->price }}
                </p>
            </div>

            <hr>
        @endforeach
    @else
        <p>
            This teacher has no courses.
        </p>

    @endif

</body>

</html>
