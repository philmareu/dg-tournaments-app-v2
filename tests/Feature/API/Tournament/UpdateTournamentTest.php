<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Format;
use App\Models\PdgaTier;
use App\Models\SpecialEventType;
use App\Models\Tournament;
use App\Models\Upload;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UpdateTournamentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function only_a_manager_can_edit_tournament_basic_information()
    {
        $tournament = $this->createTournament();

        $this->actingAs($this->createUser())
            ->json('PUT', '/tournament/' . $tournament->id)
            ->assertStatus(403);
    }

    #[Test]
    public function manager_can_edit_all_fields_for_self_listed_events()
    {
        $user = $this->createUser();
        $tournament = $this->createTournament();
        $tournament->specialEventTypes()->save(SpecialEventType::factory()->create());
        $tournament->managers()->sync([$user->id]);

        $data = [
            'name' => 'Test Tournament',
            'city' => 'Lawrence',
            'state_province' => 'Kansas',
            'country' => 'USA',
            'latitude' => '100.00',
            'longitude' => '-45.00',
            'start' => '1-1-2000',
            'end' => '1-1-2000',
            'email' => 'email@email.com',
            'phone' => '785-555-5555',
            'director' => 'Director',
            'description' => 'A disc golf tournament',
            'poster_id' => Upload::factory()->create()->id,
            'format_id' => Format::factory()->create()->id,
            'special_event_type_ids' => SpecialEventType::factory()->count(3)->create()->pluck('id')->toArray(),
            'timezone' => 'America/Chicago'
        ];

        $response = $this->actingAs($user)
            ->json('PUT', '/tournament/' . $tournament->id, $data);

        $this->assertDatabaseHas('tournaments', [
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'city' => $data['city'],
            'state_province' => $data['state_province'],
            'country' => $data['country'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'director' => $data['director'],
            'timezone' => $data['timezone'],
            'description' => $data['description'],
            'poster_id' => $data['poster_id'],
            'format_id' => $data['format_id']
        ]);

        $tournament->refresh();

        $this->assertEquals($data['start'], $tournament->start->format('n-j-Y'));
        $this->assertEquals($data['end'], $tournament->end->format('n-j-Y'));
    }

    #[Test]
    public function manager_can_remove_all_special_event_types()
    {
        list($user, $tournament) = $this->createTournamentWithManager();
        $tournament->specialEventTypes()->save(SpecialEventType::factory()->create());

        $data = [
            'name' => 'Test Tournament',
            'city' => 'Lawrence',
            'state_province' => 'Kansas',
            'country' => 'USA',
            'latitude' => '100.00',
            'longitude' => '-45.00',
            'start' => '1-1-2000',
            'end' => '1-1-2000',
            'email' => 'email@email.com',
            'phone' => '785-555-5555',
            'director' => 'Director',
            'description' => 'A disc golf tournament',
            'poster_id' => Upload::factory()->create()->id,
            'format_id' => Format::factory()->create()->id,
            'special_event_type_ids' => [],
            'timezone' => 'America/Chicago'
        ];

        $this->actingAs($user)
            ->json('PUT', '/tournament/' . $tournament->id, $data);

        $tournament->refresh();

        $this->assertEmpty($tournament->load('specialEventTypes')->specialEventTypes->toArray());
    }

    #[Test]
    public function manager_can_only_edit_fields_that_are_not_synced_by_the_pdga_api()
    {
        $user = $this->createUser();
        $originalTournament = $this->createTournament();
        $originalTournament->managers()->sync([$user->id]);
        $originalTournament->pdgaTiers()->sync([PdgaTier::factory()->create()->id]);

        $data = [
            'name' => 'name changed',
            'city' => 'city-changed',
            'state_province' => 'state-changed',
            'country' => 'country-changed',
            'start' => '1-1-2000',
            'end' => '1-1-2000',
            'latitude' => '100.00',
            'longitude' => '-45.00',
            'email' => 'email@email.com',
            'phone' => '785-555-5555',
            'director' => 'Director',
            'description' => 'A disc golf tournament',
            'poster_id' => Upload::factory()->create()->id,
            'format_id' => Format::factory()->create()->id,
            'special_event_type_ids' => SpecialEventType::factory()->count(3)->create()->pluck('id')->toArray(),
            'timezone' => 'America/Chicago'
        ];

        $response = $this->actingAs($user)
            ->json('PUT', '/tournament/' . $originalTournament->id, $data);

        $updatedTournament = Tournament::find($originalTournament->id);

        $this->assertEquals($originalTournament->name, $updatedTournament->name);
        $this->assertEquals($originalTournament->slug, $updatedTournament->slug);
        $this->assertEquals($originalTournament->city, $updatedTournament->city);
        $this->assertEquals($originalTournament->state_province, $updatedTournament->state_province);
        $this->assertEquals($originalTournament->country, $updatedTournament->country);
        $this->assertEquals($originalTournament->start->format('Y-m-d'), $updatedTournament->start->format('Y-m-d'));
        $this->assertEquals($originalTournament->end->format('Y-m-d'), $updatedTournament->end->format('Y-m-d'));
    }
}
