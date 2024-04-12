<?php

namespace App\Listeners\Activity;

use App\Events\Models\SponsorshipCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSponsorshipCreatedActivity implements ShouldQueue
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
    public function handle(SponsorshipCreated $event)
    {
        $activity = $this->createActivity('tournament.sponsorship.created', $event->sponsorship->tournament, $event->user, $event->sponsorship);

        $this->attachActivityToFeeds($event->sponsorship->tournament->followers, $activity);
    }
}
