<?php

namespace Tests\Feature\API;

use App\Models\TournamentCourse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class TournamentCourseDataEndpointTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function loads_all_course_information_needed_for_the_show_page()
    {
        $tournamentCourse = TournamentCourse::factory()->create();

        $this->json('GET', 'tournament/courses/' . $tournamentCourse->id)
            ->assertJson([
                'data' => [
                    'id' => $tournamentCourse->id,
                    'tournament' => [
                        'id' => $tournamentCourse->tournament->id,
                        'managers' => []
                    ]
                ]
            ]);
    }
}
