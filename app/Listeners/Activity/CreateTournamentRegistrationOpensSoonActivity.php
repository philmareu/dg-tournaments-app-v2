<?php

namespace App\Listeners\Activity;

use App\Events\Registration\RegistrationOpensSoon;

class CreateTournamentRegistrationOpensSoonActivity
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
    public function handle(RegistrationOpensSoon $event)
    {
        $activity = $this->createActivity('tournament.registration.opens_soon', $event->registration->tournament, null, $event->registration);

        $this->attachActivityToFeeds($event->registration->tournament->followers->load('user'), $activity);
    }
}
