<?php

namespace App\Listeners\Notifications\Admin;

use App\Events\TournamentClaimApproved;
use App\Mail\User\ClaimApprovedMailable;
use Illuminate\Support\Facades\Mail;

class SendApprovedEmailToClaimRequester
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
        Mail::to($event->user->email)->send(new ClaimApprovedMailable($event->tournament));
    }
}
