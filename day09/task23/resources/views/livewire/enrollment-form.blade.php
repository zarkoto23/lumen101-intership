<div>


@if(session('success'))

<div class="border p-3 mb-3">

{{ session('success') }}

</div>

@endif




@if(session('error'))

<div class="border p-3 mb-3">

{{ session('error') }}

</div>

@endif





<button

wire:click="enroll"

class="border rounded p-2"

wire:loading.attr="disabled"

>


Enroll to course


</button>



</div>