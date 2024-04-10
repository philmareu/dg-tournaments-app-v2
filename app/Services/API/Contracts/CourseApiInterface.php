<?php

namespace App\Services\API\Contracts;


use App\Services\API\Responses\CoursesResponse;

interface CourseApiInterface
{
    public function getCourses() : CoursesResponse;
}
