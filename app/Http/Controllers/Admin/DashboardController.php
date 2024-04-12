<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Order;
use App\Models\Search;
use App\Models\Sponsorship;
use App\Models\StripeAccount;
use App\Models\TournamentSponsor;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // # users
    // # sponsorships
    // # saved searches

    public function index()
    {
        return view('admin.dashboard')
            ->withCounts([
                [
                    'title' => 'Users',
                    'quantity' => User::count(),
                ],
                [
                    'title' => 'Searches',
                    'quantity' => Search::count(),
                ],
                [
                    'title' => 'Sponsorships',
                    'quantity' => Sponsorship::count(),
                ],
                [
                    'title' => 'Follows',
                    'quantity' => Follow::count(),
                ],
                [
                    'title' => 'Managers',
                    'quantity' => DB::table('managers')->count(),
                ],
                [
                    'title' => 'Orders',
                    'quantity' => Order::count(),
                ],
                [
                    'title' => 'Stripe Accounts',
                    'quantity' => StripeAccount::count(),
                ],
                [
                    'title' => 'Tournament Sponsors',
                    'quantity' => TournamentSponsor::count(),
                ],
            ]);
    }
}
