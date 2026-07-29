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


    <h1>Add Course</h1>


    <form method="POST" action="/courses">

        @csrf

        <label>
            Teacher
        </label>

        <select name="teacher_id">

            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">
                    {{ $teacher->first_name }}
                    {{ $teacher->last_name }}
                </option>
            @endforeach

        </select>


        <input type="text" name="name" placeholder="Course name">


        <textarea name="description" placeholder="Description"></textarea>


        <input type="number" name="duration" placeholder="Duration">


        <input type="number" step="0.01" name="price" placeholder="Price">


        <button type="submit">
            Save
        </button>

    </form>


</body>

</html>
