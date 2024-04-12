<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SettingsController extends Controller implements HasMiddleware
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

    public function edit()
    {
        return view('pages.account.settings');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $request->user()->password = bcrypt($request->password);
        $request->user()->email = $request->email;
        $request->user()->save();

        return redirect()->route('account.settings')->with('success', 'Settings updated!');
    }
}
