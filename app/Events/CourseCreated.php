<?php

namespace App\Events;

use App\Models\Course;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
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
