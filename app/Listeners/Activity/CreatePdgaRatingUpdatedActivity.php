<?php

namespace App\Listeners\Activity;

use App\Events\RatingUpdatedEvent;

class CreatePdgaRatingUpdatedActivity
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
     * @return void
     */
    public function handle(RatingUpdatedEvent $event)
    {
        $activity = $this->createActivity('pdga.rating.updated', $event->user, null, collect(['old' => $event->old, 'new' => $event->new]));

        $event->user->feed()->save($activity);
    }
}
