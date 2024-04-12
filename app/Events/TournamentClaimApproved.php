<?php

namespace App\Events;

use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentClaimApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Tournament
     */
    public $tournament;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Tournament $tournament)
    {
        $this->user = $user;
        $this->tournament = $tournament;
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
