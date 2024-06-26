<?php

namespace App\Listeners\Activity;

use App\Events\TournamentRegistrationUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTournamentRegistrationUpdatedActivity implements ShouldQueue
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
    public function handle(TournamentRegistrationUpdated $event)
    {
        $activity = $this->createActivity('tournament.registration.updated', $event->registration->tournament, $event->user, $event->registration);

        $this->attachActivityToFeeds($event->registration->tournament->followers->load('user'), $activity);
    }
}
