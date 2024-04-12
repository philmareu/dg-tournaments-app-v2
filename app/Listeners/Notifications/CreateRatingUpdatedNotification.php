<?php

namespace App\Listeners\Notifications;

use App\Events\RatingUpdatedEvent;
use App\Notifications\RatingUpdated;

class CreateRatingUpdatedNotification
{
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
        $event->user->notify(new RatingUpdated($event->old, $event->new));
    }
}
