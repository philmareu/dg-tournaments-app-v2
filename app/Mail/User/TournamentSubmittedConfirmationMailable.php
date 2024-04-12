<?php

namespace App\Mail\User;

use App\Models\Tournament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TournamentSubmittedConfirmationMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tournament;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tournament Submitted')
            ->markdown('emails.user.tournament.submitted');
    }
}
