<?php

namespace App\Listeners\Activity;

use App\Events\TournamentAutoAssigned;

class CreateTournamentAutoAssignedActivity
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
    public function handle(TournamentAutoAssigned $event)
    {
        $activity = $this->createActivity('tournament.user.assigned', $event->tournament, null, $event->user);

        $this->attachActivityToFeeds($event->user, $activity);
    }
}
