<?php

namespace Tests\Unit\Data;

use App\Data\Location;
use Tests\TestCase;

class LocationDataObjectTest extends TestCase
{
    #[Test]
    public function should_show_formatted_address()
    {
        $location = new Location('TestVille', 'USA', 'Kansas');

        $this->assertEquals('TestVille, Kansas (USA)', $location->formatted());
    }
}
