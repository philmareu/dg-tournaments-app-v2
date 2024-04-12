<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\Tournament;
use App\Models\TournamentCourse;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TournamentFlagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function lat_and_lng_flag_is_added_to_tournament_with_no_lat_and_lng()
    {
        $tournament = Tournament::factory()->create([
            'latitude' => null,
            'longitude' => null
        ]);

        $this->assertDatabaseHas('flags', [
            'tournament_id' => $tournament->id,
            'flag_type_id' => 1
        ]);
    }

    /**
     * @test
     */
    public function needs_course_flag_added_by_default_to_new_tournament()
    {
        $tournament = Tournament::factory()->create([
            'latitude' => null,
            'longitude' => null
        ]);

        $this->assertDatabaseHas('flags', [
            'tournament_id' => $tournament->id,
            'flag_type_id' => 2
        ]);
    }

    /**
     * @test
     */
    public function needs_registration_link_flag_added_by_default_to_new_tournament()
    {
        $tournament = Tournament::factory()->create([
            'latitude' => null,
            'longitude' => null
        ]);

        $this->assertDatabaseHas('flags', [
            'tournament_id' => $tournament->id,
            'flag_type_id' => 3
        ]);
    }

    /**
     * @test
     */
    public function maintenance_script_flag_tournaments_will_create_flags_for_tournaments_missing_lat_and_lng()
    {
        Event::fake();

        $tournamentsNoGeo = Tournament::factory()->count(3)->states('no-geo', 'future')->create();
        $tournamentsWithGeo = Tournament::factory()->count(3)->states('future')->create();

        $this->artisan('maintenance:flag-tournaments');

        $tournamentsNoGeo->each(function(Tournament $tournament) {
            $this->assertDatabaseHas('flags', [
                'tournament_id' => $tournament->id,
                'flag_type_id' => 1
            ]);
        });

        $tournamentsWithGeo->each(function(Tournament $tournament) {
            $this->assertDatabaseMissing('flags', [
                'tournament_id' => $tournament->id,
                'flag_type_id' => 1
            ]);
        });

    }

    /**
     * @test
     */
    public function maintenance_script_flag_tournaments_will_create_flags_for_tournaments_missing_courses()
    {
        Event::fake();

        $tournamentsNoCourses = Tournament::factory()->count(3)->create();
        $tournamentsWithCourses = Tournament::factory()->count(3)->create()->each(function(Tournament $tournament) {
            $tournament->courses()->save(TournamentCourse::factory()->make());
        });

        $this->artisan('maintenance:flag-tournaments');

        $tournamentsNoCourses->each(function(Tournament $tournament) {
            $this->assertDatabaseHas('flags', [
                'tournament_id' => $tournament->id,
                'flag_type_id' => 2
            ]);
        });

        $tournamentsWithCourses->each(function(Tournament $tournament) {
            $this->assertDatabaseMissing('flags', [
                'tournament_id' => $tournament->id,
                'flag_type_id' => 2
            ]);
        });

    }

    /**
     * @test
     */
    public function maintenance_script_flag_tournaments_will_create_flags_for_tournaments_missing_registration()
    {
        Event::fake();

        $tournamentsNoRegistration = Tournament::factory()->count(3)->create();
        $tournamentsWithRegistration = Tournament::factory()->count(3)->create()->each(function(Tournament $tournament) {
            $tournament->registration()->save(Registration::factory()->make());
        });

        $this->artisan('maintenance:flag-tournaments');

        $tournamentsNoRegistration->each(function(Tournament $tournament) {
            $this->assertDatabaseHas('flags', [
                'tournament_id' => $tournament->id,
                'flag_type_id' => 3
            ]);
        });

        $tournamentsWithRegistration->each(function(Tournament $tournament) {
            $this->assertDatabaseMissing('flags', [
                'tournament_id' => $tournament->id,
                'flag_type_id' => 3
            ]);
        });

    }
}
