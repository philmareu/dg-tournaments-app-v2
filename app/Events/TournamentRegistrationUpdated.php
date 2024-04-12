<?php

namespace App\Events;

use App\Models\Registration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentRegistrationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $registration;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration->load('tournament');
        $this->user = auth()->user();
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
