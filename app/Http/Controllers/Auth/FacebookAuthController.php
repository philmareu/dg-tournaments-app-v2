<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserActivated;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller implements HasMiddleware
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
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Social.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            if (is_null($user->getEmail())) {
                Log::info('User did not approve email access.');

                return $this->showFailedResponse();
            }
        } catch (\Exception $exception) {
            return $this->showFailedResponse();
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
            'provider' => 'facebook',
            'provider_id' => $user->getId(),
            'token' => $user->token,
        ]);

        $newUser->activated = 1;
        $newUser->save();

        event(new Registered($newUser));
        event(new NewUserActivated($user));

        return $newUser;
    }

    private function showFailedResponse()
    {
        return redirect('login')->with('failed', 'Login with Facebook was unsuccessful');
    }
}
