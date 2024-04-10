<?php

namespace App\Listeners\Notifications\Admin;

use App\Events\TournamentClaimApproved;
use App\Models\User\User;
use App\Notifications\TournamentClaimedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  TournamentClaimApproved  $event
     * @return void
     */
    public function handle(TournamentClaimApproved $event)
    {
        User::find(1)->notify(new TournamentClaimedNotification($event->user, $event->tournament));
    }
}
