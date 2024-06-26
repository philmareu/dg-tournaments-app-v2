<?php

namespace App\Listeners\EmailNotifications;

use App\Events\OrderPaid;
use App\Mail\User\OrderConfirmationMailable;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail
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
    public function handle(OrderPaid $event)
    {
        Mail::to($event->order->email)
            ->send(new OrderConfirmationMailable($event->order));
    }
}
