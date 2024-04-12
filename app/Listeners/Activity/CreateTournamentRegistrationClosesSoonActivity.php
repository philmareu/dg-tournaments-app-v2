<?php

namespace App\Listeners\Activity;

use App\Events\Registration\RegistrationClosesSoon;

class CreateTournamentRegistrationClosesSoonActivity
{
    use SavesActivities;

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
    public function handle(RegistrationClosesSoon $event)
    {
        $activity = $this->createActivity('tournament.registration.closes_soon', $event->registration->tournament, null, $event->registration);

        $this->attachActivityToFeeds($event->registration->tournament->followers->load('user'), $activity);
    }
}
