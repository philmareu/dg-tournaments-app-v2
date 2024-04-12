<?php

namespace App\Listeners\Operations;

use App\Events\TournamentClaimApproved;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteClaimRequest implements ShouldQueue
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
    public function handle(TournamentClaimApproved $event)
    {
        $event->tournament->claimRequest->delete();
    }
}
