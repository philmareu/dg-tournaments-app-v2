<?php

namespace App\Listeners\Activity;

use App\Events\TournamentUnfollowed;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTournamentUnfollowedActivity implements ShouldQueue
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
    public function handle(TournamentUnfollowed $event)
    {
        $this->createActivity('tournament.unfollowed', $event->tournament, $event->user);
    }
}
