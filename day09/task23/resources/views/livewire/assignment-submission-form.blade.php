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





<input

type="file"

wire:model="file"

class="border p-2"



>




<textarea

wire:model="comment"

placeholder="Comment"

class="border p-2 mt-2"

></textarea>





<button

wire:click="submit"

class="border p-2 mt-2"

wire:loading.attr="disabled"

>

Submit

</button>



</div>