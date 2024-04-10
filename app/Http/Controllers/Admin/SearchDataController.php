<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Tournament;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchDataController extends Controller
{
    public function events()
    {
        return Tournament::get();
    }

    public function courses()
    {
        return Course::get(['course_id', 'course_name', 'city', 'state_province', 'country']);
    }
}
