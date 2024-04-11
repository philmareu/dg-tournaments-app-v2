<?php

namespace App\Http\Controllers\Endpoints;

use App\Billing\Stripe\StripeBilling;
use App\Data\Time;
use App\Http\Requests\Endpoints\CreateStripeCustomerRequest;
use App\Http\Requests\Endpoints\CreateRefundRequest;
use App\Http\Requests\Endpoints\PayOrderWithStripeRequest;
use App\Http\Requests\Endpoints\ProcessOrderDetailsRequest;
use App\Http\Requests\User\AddCardRequest;
use App\Models\OrderSponsorship;
use App\Models\Sponsorship;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderEndpointController extends Controller
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    protected $userRepository;

    protected $billing;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository, StripeBilling $billing)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->billing = $billing;
    }

    public function addSponsorship(Request $request, Sponsorship $sponsorship)
    {
        $order = $this->orderRepository->addSponsorship($sponsorship, $request->cookie('_oo'));

        $order->load('sponsorships.sponsorship.tournament.poster');

        return response($order)->cookie('_oo', $order->unique, Time::make()->hours(48)->inMinutes());
    }

    public function destroySponsorship(OrderSponsorship $orderSponsorship)
    {
        $order = $orderSponsorship->order;

        $this->orderRepository->removeSponsorship($orderSponsorship);

        $order->load('sponsorships.sponsorship.tournament.poster');

        return response($order)->cookie('_oo', $order->unique, Time::make()->hours(48)->inMinutes());
    }

    public function processDetails(ProcessOrderDetailsRequest $request)
    {
        $order = $this->orderRepository->processCustomerDetails($request->unique, $request->all());

        if(Auth::guest() && $request->has(['create_account', 'password']))
        {
            $user = $this->userRepository->registerNewUser(array_merge(
                ['password' => bcrypt($request->password)],
                $request->only('email', 'first_name', 'last_name'),
                ['name' => $request->first_name . ' ' . $request->last_name]
            ));

            $order->user()->associate($user)->save();

            Auth::login($user);
        }

        return $order->load('sponsorships.sponsorship.tournament.poster');
    }

    public function pay(PayOrderWithStripeRequest $request)
    {
        $order = $this->orderRepository->getOrderByUnique($request->unique);

        $order =  $this->orderRepository->pay($order, $request->source, Auth::user());

        if(Auth::check()) $order->user()->associate(Auth::user())->save();

        return $order;
    }
}
