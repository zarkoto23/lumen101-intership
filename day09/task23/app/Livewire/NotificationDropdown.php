<?php

namespace App\Livewire;


use Illuminate\Support\Facades\Auth;


use Livewire\Component;



class NotificationDropdown extends Component
{


    public function markAsRead($id)
    {

        $notification = Auth::user()

            ->notifications()

            ->where('id', $id)

            ->first();



        if($notification){

            $notification->markAsRead();

        }

    }





    public function markAllAsRead()
    {

        Auth::user()

            ->unreadNotifications()

            ->update([

                'read_at'=>now()

            ]);

    }





    public function render()
    {

        $user = Auth::user();



        $notifications = $user

            ? $user->notifications()
                ->latest()
                ->limit(5)
                ->get()

            : collect();




        $unread = $user

            ? $user->unreadNotifications()->count()

            : 0;




        return view(

            'livewire.notification-dropdown',

            compact(

                'notifications',

                'unread'

            )

        );

    }


}