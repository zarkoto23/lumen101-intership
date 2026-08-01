<div>


<div class="mb-5">


<input

type="text"

wire:model.live="search"

placeholder="Search courses"

class="border p-2"



>



<select wire:model.live="level"

class="border p-2">


<option value="">
All levels
</option>


<option value="beginner">
Beginner
</option>


<option value="intermediate">
Intermediate
</option>


<option value="advanced">
Advanced
</option>


</select>




<select wire:model.live="sort"

class="border p-2">


<option value="latest">
Latest
</option>


<option value="price">
Price
</option>


</select>



</div>





<div class="grid grid-cols-3 gap-5">


@foreach($courses as $course)


<div class="border p-4">


<h2 class="font-bold">

{{ $course->title }}

</h2>



<p>

{{ $course->short_description }}

</p>



<p>

{{ $course->price }} €

</p>




<a

href="{{ route('courses.show',$course) }}"

class="border p-2 inline-block mt-3"

>

View

</a>


</div>



@endforeach


</div>




<div class="mt-5">

{{ $courses->links() }}

</div>



</div>