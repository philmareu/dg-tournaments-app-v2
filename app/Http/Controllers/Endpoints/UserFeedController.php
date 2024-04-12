<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Models\Activity;

class UserFeedController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return response('Not authorized', 401);
        }

        return auth()->user()->feed->map(function (Activity $activity) {
            return view('partials.activities.activity')->withActivity($activity)->render();
        });
    }
}
