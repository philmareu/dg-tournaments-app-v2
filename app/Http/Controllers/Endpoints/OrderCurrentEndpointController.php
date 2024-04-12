<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderCurrentEndpointController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(Request $request)
    {
        $order = $this->orderRepository->getOrderByUnique($request->cookie('_oo'));

        return is_null($order) ? null : $order->load('sponsorships.sponsorship.tournament.poster', 'user');
    }
}
