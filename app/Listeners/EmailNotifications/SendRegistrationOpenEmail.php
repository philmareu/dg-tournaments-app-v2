<?php

namespace App\Listeners\EmailNotifications;

use App\Events\Registration\RegistrationIsOpen;
use App\Mail\User\RegistrationIsOpenMailable;
use App\Models\Follow;
use Illuminate\Support\Facades\Mail;

class SendRegistrationOpenEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(RegistrationIsOpen $event)
    {
        $event->registration->tournament->followers->filter(function (Follow $follow) {
            return (bool) $follow->user->emailNotificationSettings->where('id', 2)->count();
        })->each(function (Follow $follow) use ($event) {
            Mail::to($follow->user->email)
                ->send(new RegistrationIsOpenMailable($event->registration));
        });
    }
}
