<?php

namespace App\Listeners\Activity;

use App\Events\TournamentSubmitted;

class CreateTournamentSubmittedActivity
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
    public function handle(TournamentSubmitted $event)
    {
        $this->createActivity('tournament.submitted', $event->tournament, $event->user);
    }
}
