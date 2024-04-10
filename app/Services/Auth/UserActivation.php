<?php namespace App\Services\Auth;

use App\Mail\User\Activation;
use App\Models\User\User;
use App\Repositories\ActivationRepository;
use Illuminate\Support\Facades\Mail;

class UserActivation
{
    protected $activationRepository;

    protected $resendAfter = 24;

    public function __construct(ActivationRepository $activationRepository)
    {
        $this->activationRepository = $activationRepository;
    }

    public function sendActivationMail(User $user)
    {

        if ($user->activated || ! $this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepository->createActivation($user);

        Mail::to($user->email)->send(new Activation($user, route('user.activate', $token)));
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepository->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;

        $user->save();

        $this->activationRepository->deleteActivation($token);

        return $user;
    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepository->getActivation($user);
        return $activation === null || $activation->created_at->diffInHours > $this->resendAfter;
    }
}
