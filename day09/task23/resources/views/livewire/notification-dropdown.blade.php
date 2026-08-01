<div class="border p-3">


<div class="font-bold mb-3">

Notifications ({{ $unread }})

</div>




@if($unread > 0)

<button

wire:click="markAllAsRead"

class="border p-2 mb-3"

>

Mark all read

</button>

@endif





@forelse($notifications as $notification)



<div class="border-b p-2">


<p>

{{ $notification->data['message'] ?? 'Notification' }}

</p>




@if(!$notification->read_at)


<button

wire:click="markAsRead('{{ $notification->id }}')"

class="text-sm border p-1"

>

Mark read

</button>


@endif



</div>



@empty


<p>
No notifications
</p>


@endforelse



</div>