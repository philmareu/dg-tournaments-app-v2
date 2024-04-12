<?php

namespace App\Listeners\Notifications\Admin;

use App\Events\TournamentClaimApproved;
use App\Models\User\User;
use App\Notifications\TournamentClaimedNotification;

class SendTournamentClaimedNotification
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
        User::find(1)->notify(new TournamentClaimedNotification($event->user, $event->tournament));
    }
}
