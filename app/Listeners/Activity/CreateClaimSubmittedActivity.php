<?php

namespace App\Listeners\Activity;

use App\Events\TournamentClaimRequestSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateClaimSubmittedActivity implements ShouldQueue
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
    public function handle(TournamentClaimRequestSubmitted $event)
    {
        $this->createActivity('tournament.claim.submitted', $event->claimRequest->tournament, $event->claimRequest->user);
    }
}
