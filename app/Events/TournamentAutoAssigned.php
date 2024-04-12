<?php

namespace App\Events;

use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentAutoAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tournament;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tournament $tournament, User $user)
    {
        $this->tournament = $tournament;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
