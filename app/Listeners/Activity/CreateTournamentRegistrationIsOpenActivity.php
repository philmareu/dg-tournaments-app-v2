<?php

namespace App\Listeners\Activity;

use App\Events\Registration\RegistrationIsOpen;

class CreateTournamentRegistrationIsOpenActivity
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
    public function handle(RegistrationIsOpen $event)
    {
        $activity = $this->createActivity('tournament.registration.is_open', $event->registration->tournament, null, $event->registration);

        $this->attachActivityToFeeds($event->registration->tournament->followers->load('user'), $activity);
    }
}
