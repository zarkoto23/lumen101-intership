<div>


<h1 class="text-2xl font-bold mb-5">

{{ $course->title }}

</h1>



<div class="border p-3 mb-5">

Progress:

{{ $progress }} %

</div>





@foreach($sections as $section)


<h2 class="font-bold text-xl mt-5">

{{ $section->title }}

</h2>




@foreach($section->lessons as $lesson)



<div class="border p-3 mt-2">


<p>

{{ $lesson->title }}

</p>



<button

wire:click="completeLesson({{ $lesson->id }})"

class="border p-2 mt-2"

>

Complete

</button>



</div>



@endforeach



@endforeach



</div>