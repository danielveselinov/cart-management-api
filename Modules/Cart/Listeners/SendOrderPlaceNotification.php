<?php

namespace Modules\Cart\Listeners;

use Modules\Cart\Events\OrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Cart\Emails\OrderPlacedNotification;

class SendOrderPlaceNotification
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
     * @param OrderPlaced $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        Mail::to($event->user->email)->send(new OrderPlacedNotification($event->user));
    }
}
