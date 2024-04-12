<?php

namespace App\Listeners\Activity;

use App\Events\LinkSaved;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLinkSavedActivity implements ShouldQueue
{
    use SavesActivities;

    protected $activity;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(LinkSaved $event)
    {
        if ($this->noRecentActivity($event)) {
            $activity = $this->createActivity('tournament.links.updated', $event->link->tournament, $event->user);
            $this->attachActivityToFeeds($event->link->tournament->followers, $activity);
        }
    }

    /**
     * @return mixed
     */
    private function noRecentActivity(LinkSaved $event)
    {
        $activity = $this->activity
            ->where('type', 'tournament.links.updated')
            ->where('resource_id', $event->link->tournament->id)
            ->where('created_at', '>', Carbon::now()->subHours(6))
            ->count();

        return (bool) $activity == 0;
    }
}
