<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Tournament;

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
