<?php

namespace App\Listeners;

use App\Mail\PasswordResetEmail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail
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
    public function handle(PasswordReset $event)
    {
        $email = $event->email;
        Mail::to($email)
            ->send(new PasswordResetEmail($email,$event->token));
    }
}
