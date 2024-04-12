<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Format;
use App\Models\Sponsorship;
use App\Models\Tournament;
use App\Models\TournamentCourse;
use App\Models\Transfer;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageTournamentController extends Controller implements HasMiddleware
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.index')
            ->withTournament($tournament);
    }

    public function basics(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.basics')
            ->withTournament($tournament->load('poster', 'pdgaTiers', 'registration', 'playerPacks.items', 'links', 'media', 'classes', 'format'))
            ->withTimezones(timezone_identifiers_list())
            ->withClasses(Classes::all())
            ->withFormats(Format::all());
    }

    public function schedule(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.schedule')
            ->withTournament($tournament);
    }

    public function registration(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.registration')
            ->withTournament($tournament->load('registration'));
    }

    public function links(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.links')
            ->withTournament($tournament->load('links'));
    }

    public function media(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.media')
            ->withTournament($tournament->load('media'));
    }

    public function playerPacks(Tournament $tournament)
    {
        if ($this->doesNotHaveAccess($tournament)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.player_packs')
            ->withTournament($tournament->load('playerPacks.items'));
    }

    public function course(Tournament $tournament, TournamentCourse $tournamentCourse)
    {
        if ($this->doesNotHaveAccess($tournament) || $tournamentCourse->tournament_id != $tournament->id) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.course')
            ->withTournament($tournament)
            ->withCourse($tournamentCourse);
    }

    public function sponsorship(Tournament $tournament, Sponsorship $sponsorship)
    {
        if ($this->doesNotHaveAccess($tournament) || $sponsorship->tournament_id != $tournament->id) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.sponsorship')
            ->withTournament($tournament)
            ->withSponsorship($sponsorship->load('tournamentSponsors.sponsor.logo'));
    }

    public function sponsorships(Tournament $tournament)
    {
        if (! request()->user()->hasAccessToTournament($tournament->id)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.sponsorships')
            ->withTournament($tournament->load('sponsorships.tournamentSponsors.sponsor.logo'));
    }

    public function creditCard(Tournament $tournament)
    {
        if (! request()->user()->hasAccessToTournament($tournament->id)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.card')
            ->withTournament($tournament);
    }

    public function orders(Request $request, Tournament $tournament)
    {
        if (! $request->user()->hasAccessToTournament($tournament->id)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.orders')
            ->withTournament($tournament->load('transfers'));
    }

    public function followers(Request $request, Tournament $tournament)
    {
        if (! $request->user()->hasAccessToTournament($tournament->id)) {
            return response('Not authorized', 403);
        }

        return view('pages.manage.tournament.followers')
            ->withTournament($tournament->load('followers'));
    }

    public function order(Request $request, Tournament $tournament, Transfer $transfer)
    {
        if (! $request->user()->hasAccessToTournament($tournament->id) || $transfer->tournament_id != $tournament->id) {
            return response('Not authorized', 403);
        }

        //        $order = $this->orderRepository->getTournamentOrder($tournament, 1);

        //        dd($order);

        //        if(is_null($order)) abort(404);

        //        $sponsorships = $this->orderRepository->getTournamentOrderSponsorships($tournament, $orderId);

        //        dd($sponsorships);

        //        $transfer = $this->orderRepository->getTournamentOrderTransfer($tournament, $orderId);

        //        dd($transfer);

        return view('pages.manage.tournament.order')
            ->withTournament($tournament)
            ->withTransfer($transfer->load('sponsorships.sponsorship'));
    }

    private function doesNotHaveAccess($tournament)
    {
        return ! auth()->user()->hasAccessToTournament($tournament->id);
    }
}
