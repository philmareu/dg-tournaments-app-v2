<?php

namespace App\Http\Controllers\Account;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.account.orders.index')
            ->withOrders($this->orderRepository->getUsersOrders(auth()->user()));
    }

    public function show(Order $order)
    {
        if($order->user_id !== auth()->user()->id) return response('Not authorized', 403);

        return view('pages.account.orders.show')
            ->withOrder($order->load('sponsorships.sponsorship.tournament.poster'));
    }
}
