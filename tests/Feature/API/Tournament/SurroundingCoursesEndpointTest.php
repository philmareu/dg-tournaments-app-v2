<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Course;
use App\Models\Tournament;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class SurroundingCoursesEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = 'tournament/surrounding-courses/';

    /*
    |--------------------------------------------------------------------------
    | GET
    |--------------------------------------------------------------------------
    */

    #[Test]
    public function guests_can_not_retrieve_list_of_surrounding_courses()
    {

        $this->json('GET', $this->endpoint . Tournament::factory()->create()->id)
            ->assertStatus(401);
    }

    #[Test]
    public function should_return_a_list_of_courses_within_a_set_range_of_given_tournament()
    {
        $defaultDistance = 2;

        $tournament = Tournament::factory()->create();

        $courses = Course::factory()->count(3)->create()->each(function(Course $course) use ($tournament, $defaultDistance) {
            $course->update([
                'latitude' => $tournament->latitude + rand(0, $defaultDistance * 99) / 100,
                'longitude' => $tournament->longitude + rand(0, $defaultDistance * 99) / 100
            ]);
        });

        $this->actingAs($this->createUser())
            ->json('GET', $this->endpoint . $tournament->id)
            ->assertStatus(200)
            ->assertJson($courses->only('name')->toArray());
    }
}
