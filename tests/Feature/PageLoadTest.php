<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageLoadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

//        Artisan::call('db:seed');
    }

    #[DataProvider('provideGuestRoutes')]
    public function testGuestPageLoads($method, $route)
    {
        $response = $this->call($method, $route);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function provideGuestRoutes()
    {
        return [
            ['GET', '/'],
//            ['GET', 'disc-golf-tournament/1/dgt-open-sanctioned']
        ];
    }
}
