<?php

namespace App\Listeners\Notifications;

use App\Events\RatingUpdatedEvent;
use App\Models\Notification;
use App\Notifications\RatingUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  RatingUpdatedEvent  $event
     * @return void
     */
    public function handle(RatingUpdatedEvent $event)
    {
        $event->user->notify(new RatingUpdated($event->old, $event->new));
    }
}
