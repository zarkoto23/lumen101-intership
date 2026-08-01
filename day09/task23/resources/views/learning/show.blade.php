<!DOCTYPE html>

<html>

<head>

<title>

Learning

</title>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])


</head>


<body>


<div class="p-6">


<h1 class="text-3xl font-bold">

{{ $enrollment->course->title }}

</h1>



<div class="mt-4">


Progress:

{{ $progress }} %

</div>




@foreach($enrollment->course->sections as $section)



<h2 class="text-xl font-bold mt-8">

{{ $section->title }}

</h2>





@foreach($section->lessons as $lesson)



<div class="border p-4 mt-3">


<p>

{{ $lesson->title }}

</p>




<form method="POST"

action="{{ route('lesson.complete',$lesson) }}">


@csrf



<input type="hidden"

name="enrollment_id"

value="{{ $enrollment->id }}">



<button class="border rounded p-2 mt-2">

Mark completed

</button>



</form>


</div>



@endforeach



@endforeach



</div>


</body>

</html>