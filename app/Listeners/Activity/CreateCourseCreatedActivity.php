<?php

namespace App\Listeners\Activity;

use App\Events\CourseCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCourseCreatedActivity implements ShouldQueue
{
    use SavesActivities;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CourseCreated  $event
     * @return void
     */
    public function handle(CourseCreated $event)
    {
        $this->createActivity('course.created', $event->course, $event->user);
    }
}
