<div>


<h1 class="text-2xl font-bold mb-5">

My Courses

</h1>



@foreach($enrollments as $enrollment)



<div class="border p-4 mb-4">



<h2 class="font-bold">

{{ $enrollment->course->title }}

</h2>



<p>

Status:
{{ $enrollment->status }}

</p>




<p>

Grade:
{{ $enrollment->final_grade ?? 'Not graded' }}

</p>





@if($enrollment->payment)

<p>

Payment:
{{ $enrollment->payment->status }}

</p>

@endif





@if($enrollment->certificate)

<p>

Certificate:
{{ $enrollment->certificate->certificate_number }}

</p>

@endif



</div>



@endforeach



</div>