<?php

namespace App\Events;

use App\Models\Follow;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class TournamentFollowed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $follow;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
        $this->user = Auth::user();
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
