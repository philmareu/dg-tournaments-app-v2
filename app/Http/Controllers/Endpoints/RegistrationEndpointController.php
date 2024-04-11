<?php

namespace App\Http\Controllers\Endpoints;

use App\Models\Tournament;
use Carbon\Carbon;
use App\Events\TournamentRegistrationUpdated;
use App\Http\Requests\Endpoints\Tournament\StoreTournamentRegistrationRequest;
use App\Http\Requests\Endpoints\Tournament\UpdateTournamentRegistrationRequest;
use App\Models\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RegistrationEndpointController extends Controller implements HasMiddleware
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

    public function store(StoreTournamentRegistrationRequest $request, Tournament $tournament)
    {
        $tournament->registration()->create([
            'opens_at' => Carbon::createFromFormat('n-j-Y', $request->opens_at),
            'closes_at' => $request->filled('closes_at') ? Carbon::createFromFormat('n-j-Y', $request->closes_at) : null,
            'url' => $request->filled('url') ? $request->url : null
        ]);

        return $tournament->registration;
    }

    public function update(UpdateTournamentRegistrationRequest $request, Registration $registration)
    {
        if($request->has('opens_at')) $registration->opens_at = Carbon::createFromFormat('n-j-Y', $request->opens_at);
        if($request->filled('closes_at')) $registration->closes_at = Carbon::createFromFormat('n-j-Y', $request->closes_at);
        else $registration->closes_at = null;

        $registration->url = $request->has('url') ? $request->url : null;

        $registration->save();

        return $registration;
    }
}
