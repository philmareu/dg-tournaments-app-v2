<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserFollowsEndpointController extends Controller implements HasMiddleware
{
    public function __construct()
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function tournament(Tournament $tournament)
    {
        if ($this->tournamentIsFollowed($tournament)) {
            $this->removeTournament($tournament);
        } else {
            $this->saveNewFollow($tournament);
        }

        return $this->getCurrentUser()->load('following');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|User
     */
    public function getCurrentUser()
    {
        return Auth::user();
    }

    private function tournamentIsFollowed(Tournament $tournament)
    {
        return (bool) $this->getCurrentUser()
            ->following()
            ->where('resource_type', 'App\Models\Tournament')
            ->where('resource_id', $tournament->id)
            ->get()
            ->count();
    }

    private function removeTournament($tournament)
    {
        $this->getCurrentUser()
            ->following()
            ->where('resource_type', 'App\Models\Tournament')
            ->where('resource_id', $tournament->id)
            ->get()
            ->each(function (Follow $follow) {
                $follow->delete();
            });
    }

    /**
     * @param  Tournament  $tournament
     */
    public function saveNewFollow($tournament)
    {
        $follow = new Follow();
        $follow->user()->associate($this->getCurrentUser());
        $follow->resource()->associate($tournament)->save();
        $this->getCurrentUser()->following()->save($follow);
    }
}
