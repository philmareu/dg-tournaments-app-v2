<?php

namespace App\Mail\Directors;

use App\Models\Tournament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimRequest extends Mailable implements ShouldQueue
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
        $this->tournament = $tournament->load('claimRequest');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('admin@dgtournaments.com', 'DG Tournaments')
            ->subject('Claim Tournament Page')
            ->markdown('emails.directors.claim.requested');
    }
}
