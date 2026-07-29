<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Teachers</title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>


    <nav>
        <a href="/dashboard">Dashboard</a> |
        <a href="/teachers">Teachers</a> |
        <a href="/courses">Courses</a>
    </nav>



    <h1>Teachers</h1>


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



    <a class="btn" href="/teachers/create">
        Add Teacher
    </a>



    @foreach ($teachers as $teacher)
        <div class="teacher">


            <h3>
                {{ $teacher->first_name }}
                {{ $teacher->last_name }}
            </h3>


            <p>
                Email:
                {{ $teacher->email }}
            </p>


            <p>
                Specialization:
                {{ $teacher->specialization }}
            </p>


            <p>
                Courses:
                {{ $teacher->courses->count() }}
            </p>



            <div class="actions">


                <a class="btn view-btn" href="/teachers/{{ $teacher->id }}">
                    View details
                </a>



                <a class="btn edit-btn" href="/teachers/{{ $teacher->id }}/edit">
                    Edit
                </a>



                <form action="/teachers/{{ $teacher->id }}" method="POST">

                    @csrf
                    @method('DELETE')


                    <button class="delete-btn" type="submit">
                        Delete
                    </button>


                </form>


            </div>


        </div>
    @endforeach



</body>

</html>
