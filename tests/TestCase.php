<?php

namespace Tests;

use App\Models\Order;
use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        config(['scout.driver' => null]);

        if (Schema::hasTable('flag_types')) {
            $this->seed('FlagTypesSeeder');
        }
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        return User::factory()->create();
    }

    /**
     * @return Tournament
     */
    protected function createTournament()
    {
        return Tournament::factory()->create();
    }

    /**
     * @return Order
     */
    protected function createOrder()
    {
        return Order::factory()->create();
    }

    protected function createTournamentWithManager()
    {
        $user = $this->createUser();
        $tournament = $this->createTournament();
        $tournament->managers()->save($user);

        return [$user, $tournament];
    }

    protected function checkGuestAccess($method, $endpoint)
    {

        $this->json($method, $endpoint)->assertStatus(401);
    }

    protected function checkManagerAccess($method, $endpoint)
    {

        $this->actingAs($this->createUser())->json($method, $endpoint)->assertStatus(403);
    }
}
