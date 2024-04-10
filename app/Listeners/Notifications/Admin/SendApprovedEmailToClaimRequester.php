<?php

namespace App\Listeners\Notifications\Admin;

use App\Events\TournamentClaimApproved;
use App\Mail\User\ClaimApprovedMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
     * @param  TournamentClaimApproved  $event
     * @return void
     */
    public function handle(TournamentClaimApproved $event)
    {
        Mail::to($event->user->email)->send(new ClaimApprovedMailable($event->tournament));
    }
}
