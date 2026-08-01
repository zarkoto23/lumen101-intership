<!DOCTYPE html>

<html>

<head>

    <title>
        {{ $course->title }}
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


<nav class="p-4 border-b">

    <a href="/" class="font-bold">
        Academy
    </a>

</nav>





<div class="p-6">


    <h1 class="text-3xl font-bold">

        {{ $course->title }}

    </h1>




    <p class="mt-4">

        {{ $course->description }}

    </p>





    <div class="mt-5">


        <p>
            Category:
            {{ $course->category?->name }}
        </p>



        <p>
            Instructor:
            {{ $course->instructor?->name }}
        </p>




        <p>
            Level:
            {{ $course->level }}
        </p>




        <p>
            Price:
            {{ $course->price }} €
        </p>



    </div>







    @auth


        @if(auth()->user()->isStudent())

            <div class="mt-6">

                <livewire:enrollment-form :course="$course" />

            </div>


        @endif



    @else


        <a href="{{ route('login') }}"

           class="inline-block mt-6 border rounded p-2">

            Login to enroll

        </a>


    @endauth







    <h2 class="text-2xl font-bold mt-10">

        Course content

    </h2>






    @foreach($course->sections as $section)



        <h3 class="text-xl font-bold mt-5">

            {{ $section->title }}

        </h3>




        @foreach($section->lessons as $lesson)



            <p class="mt-2">

                - {{ $lesson->title }}

            </p>



        @endforeach



    @endforeach




</div>


</body>


</html>