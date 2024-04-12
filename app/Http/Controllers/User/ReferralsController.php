<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreReferralRequest;
use App\Mail\User\SendReferral;
use App\Models\User\UserReferral;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class ReferralsController extends Controller implements HasMiddleware
{
    protected $referral;

    public function __construct(UserReferral $referral)
    {
        $this->referral = $referral;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function create()
    {
        return view('pages.account.referral');
    }

    public function store(StoreReferralRequest $request)
    {
        $referral = new UserReferral($request->only('email'));
        $referral->code = hash_hmac('sha256', $request->email, config('app.key'));
        $referral->referredBy()->associate(auth()->user());
        $referral->save();

        // Email referral
        Mail::to($request->email)->send(new SendReferral($referral));

        return redirect()->route('referral.create')->with('success', 'Awesome! Your referral has been sent. Thanks!');
    }

    public function invite(Request $request)
    {
        $referral = $this->referral->where('code', $request->code)->first();

        if (is_null($referral)) {
            abort('404');
        }

        return view('auth.register')
            ->with('referral', $referral);
    }
}
