<?php

namespace App\Listeners\Operations;

use Illuminate\Auth\Events\Registered;

class SetupNewUser
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
    public function handle(Registered $event)
    {
        $event->user->emailNotificationSettings()->attach([1, 2]);
    }
}
