<?php

namespace App\Listeners;

use App\Events\ResendPasswordCode;
use App\Mail\PasswordResetNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetCode
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
     * @param  object  $event
     * @return void
     */
    public function handle(ResendPasswordCode $event)
    {
        Mail::to($event->user->email)->send(new PasswordResetNotification($event->user, $event->code));
    }
}
