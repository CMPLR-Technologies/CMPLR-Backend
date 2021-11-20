<?php

namespace App\Listeners;

use App\Notifications\WelcomeEmailNotification;
use Illuminate\Auth\Events\Registered;

class WelcomeEmailListener
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
        //$event->user->each->notify(new WelcomeEmailNotification());  
        foreach ($event as $user) {
            $user->notify(new WelcomeEmailNotification($user->email));
            break;
        }
    }
}
