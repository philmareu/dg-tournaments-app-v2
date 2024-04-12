<?php

namespace App\ImageFilters;

use Intervention\Image\Filters\FilterInterface;

class PosterSmallFilter implements FilterInterface
{
    /**
     * Applies filter to given image
     *
     * @return \Intervention\Image\Image
     */
    public function applyFilter(\Intervention\Image\Image $image)
    {
        return $image->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->crop(600, 600);
    }
}
