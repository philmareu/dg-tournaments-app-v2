<?php

namespace App\Mail\User;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationIsOpenMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $registration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Registration Open')
            ->markdown('emails.user.registration.open');
    }
}
