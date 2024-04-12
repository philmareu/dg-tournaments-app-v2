<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Endpoints\CreateRefundRequest;
use App\Mail\Admin\RefundRequestMailable;
use App\Models\Transfer;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class ManageOrderEndpointController extends Controller implements HasMiddleware
{
    public function __construct()
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function refund(CreateRefundRequest $request, Transfer $transfer)
    {
        Mail::to('admin@dgtournaments.com')
            ->send(new RefundRequestMailable($request->user(), $transfer, $request->amount));

        return response('Success', 200);
    }
}
