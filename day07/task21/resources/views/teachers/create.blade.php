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



    <h1>Add Teacher</h1>

    <form method="POST" action="/teachers">

        @csrf

        <input type="text" name="first_name" placeholder="First name">

        <input type="text" name="last_name" placeholder="Last name">

        <input type="email" name="email" placeholder="Email">

        <input type="text" name="specialization" placeholder="Specialization">

        <button type="submit">
            Save
        </button>

    </form>

</body>

</html>
