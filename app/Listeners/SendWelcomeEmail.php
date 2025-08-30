<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\WelcomeMail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle(UserRegistered $event): void
    // {
    //     //
    // }

    public function handle(UserRegistered $event)
    {
        // Send email to the registered user
        \Log::info('Sent welcome email: '.$event->user->email);

        //Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}
