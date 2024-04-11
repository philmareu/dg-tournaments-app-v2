<?php

namespace App\Http\Controllers\Account;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrdersController extends Controller implements HasMiddleware
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
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
