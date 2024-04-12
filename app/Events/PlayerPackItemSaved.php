<?php

namespace App\Events;

use App\Models\PlayerPackItem;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerPackItemSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $playerPackItem;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PlayerPackItem $playerPackItem)
    {
        $this->playerPackItem = $playerPackItem->load('playerPack.tournament');
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
