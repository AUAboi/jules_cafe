<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderPlacedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $users =  User::all()->where('is_admin', 1);
        Notification::send($users, new OrderPlaced($event->order));
    }
}
