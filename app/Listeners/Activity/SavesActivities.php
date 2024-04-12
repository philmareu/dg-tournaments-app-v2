<?php

namespace App\Listeners\Activity;

use App\Models\Activity;
use App\Models\Follow;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

trait SavesActivities
{
    public function createActivity(string $type, Model $resource, ?User $user = null, $data = null)
    {
        $activity = new Activity([
            'type' => $type,
            'data' => is_null($data) ? $resource->toJson() : $data->toJson(),
        ]);

        if (! is_null($user)) {
            $activity->user()->associate($user);
        }

        $resource->activities()->save($activity);

        return $activity;
    }

    /**
     * @param  EloquentCollection|User  $users
     */
    public function attachActivityToFeeds($users, Activity $activity)
    {
        if ($users instanceof User) {
            return $users->feed()->save($activity);
        }

        $users->each(function (Follow $follow) use ($activity) {
            $follow->user->feed()->save($activity);
        });
    }
}
