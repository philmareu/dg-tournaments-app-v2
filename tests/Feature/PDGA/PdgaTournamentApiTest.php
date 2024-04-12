<?php

namespace Tests\Feature\PDGA;

use App\Models\Classes;
use App\Models\DataSource;
use App\Models\Format;
use App\Models\Tournament;
use App\Models\User\User;
use App\Repositories\Api\TournamentRepository;
use App\Services\API\Payloads\TournamentDataPayload;
use App\Services\API\Responses\TournamentsResponse;
use App\Services\Pdga\Helpers\PdgaTournamentPayloadBuilder;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PdgaTournamentApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function tournament_api_data_passes_payload_tests()
    {
        $this->seed('ClassesTableSeeder');
        $this->seed('PdgaTierSeeder');
        $this->seed('FormatsTableSeeder');

        $this->getTournaments()->each(function($tournament) {

            $payload = new TournamentDataPayload(PdgaTournamentPayloadBuilder::make($tournament)->payload());

            $payload->verifyPayload();
        });

        $this->assertTrue(true);
    }

    #[Test]
    public function new_tournaments_are_added_from_the_api()
    {
        $this->seed('ClassesTableSeeder');
        $this->seed('PdgaTierSeeder');
        $this->seed('FormatsTableSeeder');

        $repo = new TournamentRepository(new Tournament);

        $dataSource = $this->getDataSource();

        $tournament = $repo->createNewTournament(
            $dataSource,
            $this->getPayloads()->where('id', '32490')->first()
        );

        $this->assertDatabaseHas('tournaments', [
            'data_source_id' => 1,
            'data_source_tournament_id' => '32490',
            'slug' => str_slug('Cloud 9 presents Rumble in Ragley version 4.0'),
            'name' => 'Cloud 9 presents Rumble in Ragley version 4.0',
            'city' => 'Ragley ',
            'state_province' => 'LA',
            'country' => 'United States',
            'latitude' => '30.519905',
            'longitude' => '-93.177319',
            'start' => '2017-11-11',
            'end' => '2017-11-11',
            'format_id' => '1',
            'authorization_email' => 'cajunduffer@yahoo.com'
        ]);
    }

    #[Test]
    public function tournaments_are_updated_from_the_api()
    {
        $this->seed('ClassesTableSeeder');
        $this->seed('PdgaTierSeeder');
        $this->seed('FormatsTableSeeder');

        $tournament = $this->createTournament();

        $tournament->dataSource()->associate($this->getDataSource());
        $tournament->pdgaTiers()->sync([]);
        $tournament->classes()->sync([]);
        $tournament->format()->associate(Format::factory()->create());
        $tournament->data_source_tournament_id = '32490';
        $tournament->save();

        $repo = new TournamentRepository(new Tournament);

        $repo->updateTournament(
            $tournament,
            $this->getPayloads()->where('id', '32490')->first()
        );

        $this->assertDatabaseHas('tournaments', [
            'data_source_tournament_id' => '32490',
            'slug' => str_slug('Cloud 9 presents Rumble in Ragley version 4.0'),
            'name' => 'Cloud 9 presents Rumble in Ragley version 4.0',
            'city' => 'Ragley ',
            'state_province' => 'LA',
            'country' => 'United States',
            'start' => '2017-11-11',
            'end' => '2017-11-11',
            'format_id' => '1',
            'authorization_email' => 'cajunduffer@yahoo.com'
        ]);

        $this->assertDatabaseMissing('tournaments', [
            'data_source_id' => 1,
            'data_source_tournament_id' => '32490',
            'latitude' => '30.5199047',
            'longitude' => '-93.1773192',
        ]);
    }

    #[Test]
    public function linked_tournaments_not_in_api_should_be_removed_from_database()
    {
        $this->seed('ClassesTableSeeder');
        $this->seed('PdgaTierSeeder');
        $this->seed('FormatsTableSeeder');

        $dataSource = $this->getDataSource();
        $repo = new TournamentRepository(new Tournament);

        $this->getPayloads()->each(function(TournamentDataPayload $tournament) use ($repo, $dataSource) {
            $repo->createNewTournament($dataSource, $tournament);
        });

        $tournaments = $this->getPayloads();
        $doomedTournament = $tournaments->pop();

        $this->assertDatabaseHas('tournaments', [
            'data_source_id' => $dataSource->id,
            'data_source_tournament_id' => $doomedTournament['id']
        ]);

        $repo->removeUnlisted($dataSource, $tournaments);

        $this->assertSoftDeleted('tournaments', [
            'data_source_id' => $dataSource->id,
            'data_source_tournament_id' => $doomedTournament['id']
        ]);
    }

    #[Test]
    public function new_tournaments_are_assigned_to_existing_accounts_with_same_email()
    {
        $repo = new TournamentRepository(new Tournament);

        $dataSource = $this->getDataSource();

        $this->seed('ClassesTableSeeder');
        $this->seed('PdgaTierSeeder');
        $this->seed('FormatsTableSeeder');
        $user = User::factory()->create([
            'email' => 'cajunduffer@yahoo.com'
        ]);

        $tournament = $repo->createNewTournament(
            $dataSource,
            $this->getPayloads()->where('id', '32490')->first()
        );

        $this->assertDatabaseHas('managers', [
            'user_id' => $user->id,
            'tournament_id' => $tournament->id
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTournaments() : \Illuminate\Support\Collection
    {
        return collect(json_decode(file_get_contents(base_path('tests/data/pdga/tournaments.json')), true))->reject(function($tournament) {
            return $tournament['tier'] == 'L';
        });
    }

    public function getResponse()
    {
        $payloads = $this->getTournaments()->map(function($tournament) {
            return new TournamentDataPayload(PdgaTournamentPayloadBuilder::make($tournament)->payload());
        });

        return new TournamentsResponse(200, $payloads);
    }

    public function getPayloads()
    {
        return $this->getResponse()->getPayloads();
    }

    public function getDataSource() : DataSource
    {
        return DataSource::factory()->create([
            'slug' => 'pdga',
            'type' => 'tournament'
        ]);
    }
}
