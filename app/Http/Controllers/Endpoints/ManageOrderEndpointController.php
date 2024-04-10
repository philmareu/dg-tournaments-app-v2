<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\CreateRefundRequest;
use App\Mail\Admin\RefundRequestMailable;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ManageOrderEndpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function refund(CreateRefundRequest $request, Transfer $transfer)
    {
        Mail::to('admin@dgtournaments.com')
            ->send(new RefundRequestMailable($request->user(), $transfer, $request->amount));

        return response('Success', 200);
    }
}
