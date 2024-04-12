<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;

class DirectorsController extends Controller
{
    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function index()
    {
        $directors = $this->player
            ->with('directingTournaments', 'inactiveTournaments')
            ->has('inactiveTournaments')
            ->get();

        return view('admin.directors.index')
            ->with('directors', $directors);
    }

    public function show(Player $player)
    {
        return view('admin.directors.show')
            ->with('director', $player);
    }
}
