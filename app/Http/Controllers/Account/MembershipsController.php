<?php

namespace App\Http\Controllers\Account;

use App\Http\Requests\UpdateMembershipRequest;
use App\Services\Pdga\PdgaApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MembershipsController extends Controller implements HasMiddleware
{
    protected $pdgaApi;

    public function __construct(PdgaApi $pdgaApi)
    {
        $this->pdgaApi = $pdgaApi;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function edit()
    {
        return view('pages.account.memberships.edit')
            ->withUser(auth()->user());
    }

    public function update(UpdateMembershipRequest $request)
    {
        if($request->filled('pdga_number'))
        {
            if($request->pdga_number != $request->user()->pdga_number)
            {
                $pdgaData = $this->pdgaApi->getPlayerByPdgaNumber($request->pdga_number);

                if(is_null($pdgaData)) return redirect()->route('account.memberships')->withInput()->with('failed', 'Invalid PDGA Number');

                $request->user()->update([
                    'pdga_rating' => $pdgaData['rating'],
                    'pdga_number' => $request->pdga_number
                ]);
            }
        }
        else
        {
            $request->user()->update([
                'pdga_number' => null,
                'pdga_rating' => null
            ]);
        }

        return redirect()->route('account.memberships')->with('success', 'Memberships Updated');
    }
}
