<!DOCTYPE html>

<html>

<head>

    <title>Academy</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


<nav class="p-4 border-b flex gap-4">


<a href="/">
    Academy
</a>



@auth

<a href="{{ route('dashboard') }}">
    Dashboard
</a>


<form method="POST" action="{{ route('logout') }}">

@csrf

<button>
Logout
</button>


</form>


@else


<a href="{{ route('login') }}">
Login
</a>


<a href="{{ route('register') }}">
Register
</a>


@endauth


</nav>




<div class="p-6">


<h1 class="text-3xl font-bold mb-6">

Available Courses

</h1>




@if(session('success'))

<div class="border p-3 mb-4">

{{ session('success') }}

</div>

@endif




@if(session('error'))

<div class="border p-3 mb-4">

{{ session('error') }}

</div>

@endif





<div class="grid grid-cols-1 md:grid-cols-3 gap-6">



@forelse($courses as $course)



<div class="border rounded p-5">


<h2 class="text-xl font-bold">

{{ $course->title }}

</h2>



<p class="mt-2">

{{ $course->short_description }}

</p>




<p class="mt-2">

Category:

{{ $course->category?->name }}

</p>




<p>

Instructor:

{{ $course->instructor?->name }}

</p>




<p>

Price:

{{ $course->price }} €

</p>




<a

href="{{ route('courses.show',$course) }}"

class="inline-block mt-4 border rounded p-2"

>

View Course

</a>



</div>



@empty


<p>

No courses available.

</p>


@endforelse



</div>




<div class="mt-6">

{{ $courses->links() }}

</div>



</div>


</body>

</html>