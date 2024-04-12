<?php

namespace App\Events;

use App\Models\Link;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LinkSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $link;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Link $link)
    {
        $this->link = $link->load('tournament');
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
