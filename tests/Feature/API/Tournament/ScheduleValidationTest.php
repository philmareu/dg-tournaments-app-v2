<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ScheduleValidationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function storing_a_schedule_item_requires_a_date()
    {
        $this->storing('date');
    }

    #[Test]
    public function storing_a_schedule_item_requires_a_summary()
    {
        $this->storing('summary');
    }

    #[Test]
    public function storing_a_schedule_item_the_date_must_be_a_certain_format()
    {
        $this->storing('date', ['date' => 'Not valid']);
    }

    #[Test]
    public function storing_a_schedule_item_the_start_time_must_be_a_certain_format()
    {
        $this->storing('start', ['start' => 'Not valid']);
    }

    #[Test]
    public function storing_a_schedule_item_the_end_time_must_be_a_certain_format()
    {
        $this->storing('end', ['end' => 'Not valid']);
    }

    #[Test]
    public function updating_a_schedule_item_requires_a_date()
    {
        $this->updating('date');
    }

    #[Test]
    public function updating_a_schedule_item_requires_a_summary()
    {
        $this->updating('summary');
    }

    #[Test]
    public function updating_a_schedule_item_the_date_must_be_a_certain_format()
    {
        $this->updating('date', ['date' => 'Not valid']);
    }

    #[Test]
    public function updating_a_schedule_item_the_start_time_must_be_a_certain_format()
    {
        $this->updating('start', ['start' => 'Not valid']);
    }

    #[Test]
    public function updating_a_schedule_item_the_end_time_must_be_a_certain_format()
    {
        $this->updating('end', ['end' => 'Not valid']);
    }

    private function storing($key, $data = [])
    {

        [$user, $tournament] = $this->createTournamentWithManager();

        $response = $this->actingAs($user)
            ->json('POST', 'tournament/schedule/'.$tournament->id, $data);

        $this->assertArrayHasKey($key, $response->getOriginalContent()['errors']);
    }

    private function updating($key, $data = [])
    {

        [$user, $tournament] = $this->createTournamentWithManager();
        $tournament->schedule()->save(Schedule::factory()->make());

        $response = $this->actingAs($user)
            ->json('PUT', 'tournament/schedule/'.$tournament->schedule->first()->id, $data);

        $this->assertArrayHasKey($key, $response->getOriginalContent()['errors']);
    }
}
