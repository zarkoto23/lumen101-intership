<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Courses</title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <nav>
        <a href="/dashboard">Dashboard</a> |
        <a href="/teachers">Teachers</a> |
        <a href="/courses">Courses</a>
    </nav>


    <h1>Courses</h1>


    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif


    @if (session('error'))
        <p class="error">
            {{ session('error') }}
        </p>
    @endif


    <a class="btn" href="/courses/create">
        Add Course
    </a>


    <form method="GET" action="/courses">

        <input type="text" name="search" placeholder="Search course..." value="{{ request('search') }}">


        <select name="teacher_id">

            <option value="">
                All teachers
            </option>


            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->first_name }}
                    {{ $teacher->last_name }}
                </option>
            @endforeach

        </select>


        <select name="sort">

            <option value="">
                No sorting
            </option>

            <option value="asc">
                Price low to high
            </option>

            <option value="desc">
                Price high to low
            </option>

        </select>


        <button type="submit">
            Filter
        </button>

    </form>



    @foreach ($courses as $course)
        <div class="course">

            <h3>
                {{ $course->name }}
            </h3>


            <p>
                Teacher:
                {{ $course->teacher->first_name }}
                {{ $course->teacher->last_name }}
            </p>


            <p>
                Duration:
                {{ $course->duration }}
            </p>


            <p>
                Price:
                {{ $course->price }}
            </p>



            <div class="actions">

                <a class="btn edit-btn" href="/courses/{{ $course->id }}/edit">
                    Edit
                </a>


                <form action="/courses/{{ $course->id }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="delete-btn" type="submit">
                        Delete
                    </button>

                </form>

            </div>


        </div>
    @endforeach



    <div class="pagination">

        {{ $courses->appends(request()->query())->links() }}

    </div>



</body>

</html>
