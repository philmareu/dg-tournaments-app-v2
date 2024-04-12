<?php

namespace App\Events;

use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentSubmitted
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
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
