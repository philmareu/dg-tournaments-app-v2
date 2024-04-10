<?php

namespace App\Listeners\Operations;

use App\Events\TournamentAutoAssigned;
use App\Models\Tournament;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoAssignUserToTournaments
{
    protected $tournament;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $tournaments = $this->tournament->where('authorization_email', $event->user->email)->get();

        $tournaments->each(function(Tournament $tournament) use ($event) {
            $event->user->managing()->save($tournament);

            event(new TournamentAutoAssigned($tournament, $event->user));
        });
    }
}
