<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestLog;
use Carbon\Carbon;

class SessionsController extends Controller
{
    protected $requestLog;

    public function __construct(RequestLog $requestLog)
    {
        $this->requestLog = $requestLog;
    }

    public function index()
    {
        $sessions = $this->requestLog
            ->where('created_at', '>', Carbon::now()->subWeek())
            ->orderBy('created_at', 'desc')
            ->get();

        $sessions = $sessions->groupBy('ip');

        return view('admin.sessions.index')
            ->withSessions($sessions);
    }
}
