<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserActivated;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class TwitterAuthController extends Controller implements HasMiddleware
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('guest'),
        ];
    }

    /**
     * Redirect the user to the Social authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Social.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
        } catch (\Exception $exception) {
            return redirect('login')->with('failed', 'Login with Twitter was unsuccessful');
        }

        $dgtUser = $this->findOrCreateNewUser($user);

        Auth::login($dgtUser, true);

        return redirect('/');
    }

    private function findOrCreateNewUser($user)
    {
        $existingUsers = $this->user->where('email', $user->getEmail())->first();

        if ($existingUsers) {
            return $existingUsers;
        }

        $newUser = $this->user->create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'provider' => 'twitter',
            'provider_id' => $user->getId(),
            'token' => $user->token,
            'token_secret' => $user->tokenSecret,
        ]);

        $newUser->activated = 1;
        $newUser->save();

        event(new Registered($newUser));
        event(new NewUserActivated($user));

        return $newUser;
    }
}
