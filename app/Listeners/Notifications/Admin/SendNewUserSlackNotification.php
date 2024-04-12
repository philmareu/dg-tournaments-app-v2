<?php

namespace App\Listeners\Notifications\Admin;

use App\Events\NewUserActivated;
use App\Models\User\User;

class SendNewUserSlackNotification
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
     * @return void
     */
    public function handle(NewUserActivated $event)
    {
        User::find(1)->notify(new \App\Notifications\NewUserActivated($event->user));
    }
}
