<?php

namespace Tests\Feature\API;

use App\Models\SpecialEventType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class SpecialEventTypesEndpointTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function should_return_list_of_special_event_types()
    {
        SpecialEventType::factory()->create(['title' => 'Test title 1']);
        SpecialEventType::factory()->create(['title' => 'Test title 2']);

        $this->json('GET', 'lists/special-event-types')
            ->assertJson([
                [
                    'id' => 1,
                    'title' => 'Test title 1'
                ],
                [
                    'id' => 2,
                    'title' => 'Test title 2'
                ]
            ]);
    }
}
