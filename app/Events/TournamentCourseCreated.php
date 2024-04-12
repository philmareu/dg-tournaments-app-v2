<?php

namespace App\Events;

use App\Models\TournamentCourse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentCourseCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tournamentCourse;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TournamentCourse $tournamentCourse)
    {
        $this->tournamentCourse = $tournamentCourse;
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
