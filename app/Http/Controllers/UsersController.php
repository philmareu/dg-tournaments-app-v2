<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function current()
    {
        if(is_null(auth()->user())) return null;

        return auth()->user()->load('managing', 'followingTournaments.resource.poster', 'stripeAccounts', 'sponsors', 'searches', 'image');
    }
}
