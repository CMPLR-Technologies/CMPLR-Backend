<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email,$token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$token)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Reset Password')
            ->markdown('emails.ResetPassowrdMail', [
                'token' => $this->token,
            ]);
    }
}
