<?php

namespace App\Listeners\Activity;

use App\Events\TournamentClaimApproved;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateClaimRequestApprovedActivity implements ShouldQueue
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
    public function handle(TournamentClaimApproved $event)
    {
        $this->createActivity('tournament.claim.approved', $event->tournament);
    }
}
