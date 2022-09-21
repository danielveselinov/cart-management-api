<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PasswordResetNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $code;

    /**
     * Create a new message instance.
     * @param User $user
     * @param string $code
     * @return void
     */
    public function __construct($user, $code)
    {        
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset-password-notification');
    }
}
