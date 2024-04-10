<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Flag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlagsController extends Controller
{
    public function postpone(Flag $flag, $days)
    {
        if($flag->update(['review_on' => Carbon::now()->addDays($days)])) return response('ok');

        return response('failed', 500);
    }
}
