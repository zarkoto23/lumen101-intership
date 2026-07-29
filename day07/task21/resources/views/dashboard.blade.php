<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <nav>
        <a href="/dashboard">Dashboard</a> |
        <a href="/teachers">Teachers</a> |
        <a href="/courses">Courses</a>
    </nav>

    <hr>


    <h1>Dashboard</h1>


    <div class="dashboard-grid">

        <div class="dashboard-card">
            <h3>Total teachers</h3>
            <p>{{ $teachersCount }}</p>
        </div>


        <div class="dashboard-card">
            <h3>Total courses</h3>
            <p>{{ $coursesCount }}</p>
        </div>


        <div class="dashboard-card">
            <h3>Average course price</h3>
            <p>
                {{ number_format($averagePrice, 2) }}
            </p>
        </div>


        <div class="dashboard-card">

            <h3>Most expensive course</h3>

            @if ($mostExpensiveCourse)
                <p>
                    {{ $mostExpensiveCourse->name }}
                </p>

                <strong>
                    {{ $mostExpensiveCourse->price }}
                </strong>
            @else
                <p>
                    No courses available.
                </p>
            @endif

        </div>



        <div class="dashboard-card">

            <h3>Teacher with most courses</h3>

            @if ($teacherWithMostCourses)
                <p>
                    {{ $teacherWithMostCourses->first_name }}
                    {{ $teacherWithMostCourses->last_name }}
                </p>

                <strong>
                    {{ $teacherWithMostCourses->courses_count }}
                    courses
                </strong>
            @else
                <p>
                    No teachers available.
                </p>
            @endif

        </div>


    </div>


</body>

</html>
