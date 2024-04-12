<?php

namespace App\Listeners\Activity;

use App\Events\ScheduleSaved;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateScheduleItemSavedActivity implements ShouldQueue
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
    public function handle(ScheduleSaved $event)
    {
        if ($this->noRecentActivity($event)) {
            $activity = $this->createActivity('tournament.schedule.updated', $event->schedule->tournament, $event->user);
            $this->attachActivityToFeeds($event->schedule->tournament->followers, $activity);
        }
    }

    /**
     * @return mixed
     */
    private function noRecentActivity(ScheduleSaved $event)
    {
        $activity = $this->activity
            ->where('type', 'tournament.schedule.updated')
            ->where('resource_id', $event->schedule->tournament->id)
            ->where('created_at', '>', Carbon::now()->subHours(6))
            ->count();

        return (bool) $activity == 0;
    }
}
