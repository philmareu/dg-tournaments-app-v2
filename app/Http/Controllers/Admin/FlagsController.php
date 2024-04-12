<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flag;
use Carbon\Carbon;

class FlagsController extends Controller
{
    public function postpone(Flag $flag, $days)
    {
        if ($flag->update(['review_on' => Carbon::now()->addDays($days)])) {
            return response('ok');
        }

        return response('failed', 500);
    }
}
