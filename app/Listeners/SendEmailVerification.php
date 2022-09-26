<?php

namespace App\Listeners;

use App\Mail\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification
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
    public function handle(Registered $event)
    {
        Mail::to($event->user->email)->send(new VerifyEmailNotification($event->user));
    }
}
