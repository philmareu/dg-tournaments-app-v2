<?php

namespace App\Listeners\EmailNotifications;

use App\Events\TournamentClaimRequestSubmitted;
use App\Mail\User\ClaimSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendClaimRequestConfirmationEmail implements ShouldQueue
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
        Mail::to($event->claimRequest->user->email)
            ->send(new ClaimSubmitted($event->claimRequest->tournament));
    }
}
