<?php
/**
 * Created by PhpStorm.
 * User: philmareu
 * Date: 7/25/17
 * Time: 11:41 AM
 */

namespace App\Services\API;


use App\Models\DataSource;
use App\Services\API\Contracts\CourseApiInterface;
use App\Services\API\Responses\CoursesResponse;

class CourseApi implements CourseApiInterface
{
    protected $channelApi;

    public function __construct(DataSource $dataSource)
    {
        $apiClass = $dataSource->api_class;
        $this->channelApi = new $apiClass;
    }

    static public function make(DataSource $dataSource)
    {
        return new static($dataSource);
    }

    public function getCourses() : CoursesResponse
    {
        return $this->channelApi->getCourses();
    }
}
