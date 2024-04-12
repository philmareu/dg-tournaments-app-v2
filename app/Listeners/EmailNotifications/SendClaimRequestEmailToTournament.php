<?php

namespace App\Listeners\EmailNotifications;

use App\Events\TournamentClaimRequestSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendClaimRequestEmailToTournament implements ShouldQueue
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
    public function handle(TournamentClaimRequestSubmitted $event)
    {
        Mail::to($event->claimRequest->tournament->authorization_email)
            ->send(new \App\Mail\Directors\ClaimRequest($event->claimRequest->tournament));
    }
}
