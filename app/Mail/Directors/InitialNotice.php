<?php

namespace App\Mail\Directors;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InitialNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $tournaments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tournaments)
    {
        $this->tournaments = $tournaments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('phil@dgtournaments.com', 'Phil Mareu')
            ->subject('Introducing Disc Golf Tournaments')
            ->markdown('emails.directors.initial');
    }
}
