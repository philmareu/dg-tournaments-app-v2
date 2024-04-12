<?php

namespace App\Listeners\Activity;

use App\Events\PlayerPackItemSaved;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePlayerPackItemSavedActivity implements ShouldQueue
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
    public function handle(PlayerPackItemSaved $event)
    {
        if ($this->noRecentActivity($event)) {
            $activity = $this->createActivity('tournament.player_pack.updated', $event->playerPackItem->playerPack->tournament, $event->user);
            $this->attachActivityToFeeds($event->playerPackItem->playerPack->tournament->followers, $activity);
        }
    }

    /**
     * @return mixed
     */
    private function noRecentActivity(PlayerPackItemSaved $event)
    {
        $activity = $this->activity
            ->where('type', 'tournament.player_pack.updated')
            ->where('resource_id', $event->playerPackItem->playerPack->tournament->id)
            ->where('created_at', '>', Carbon::now()->subHours(6))
            ->count();

        return (bool) $activity == 0;
    }
}
