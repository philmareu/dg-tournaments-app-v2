<?php

namespace App\Events\Models;

use App\Models\Sponsorship;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SponsorshipCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sponsorship;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
        $this->user = auth()->user();
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
