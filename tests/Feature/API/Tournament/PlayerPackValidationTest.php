<?php

namespace Tests\Feature\API\Tournament;

use App\Models\PlayerPack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PlayerPackValidationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function storing_a_player_pack_requires_a_title()
    {

        $playerPack = PlayerPack::factory()->make();
        $tournament = $this->createTournament();
        $playerPack->tournament()->associate($tournament);
        $playerPack->save();
        $user = $this->createUser();
        $user->managing()->save($tournament);
        $this->be($user);

        $response = $this->json('POST', '/tournament/player-packs/'.$tournament->id);
        $this->assertArrayHasKey('title', $response->getOriginalContent()['errors']);
    }

    #[Test]
    public function updating_a_player_pack_requires_a_title()
    {

        $playerPack = PlayerPack::factory()->make();
        $tournament = $this->createTournament();
        $playerPack->tournament()->associate($tournament);
        $playerPack->save();
        $user = $this->createUser();
        $user->managing()->save($tournament);
        $this->be($user);

        $response = $this->json('PUT', '/tournament/player-packs/'.$playerPack->id);
        $this->assertArrayHasKey('title', $response->getOriginalContent()['errors']);
    }

    #[Test]
    public function storing_a_player_pack_item_requires_a_title()
    {

        [$user, $tournament] = $this->createTournamentWithManager();
        $playerPack = $tournament->playerPacks()->save(PlayerPack::factory()->make());

        $response = $this->actingAs($user)
            ->json('POST', '/tournament/player-pack/items/'.$playerPack->id);

        $this->assertArrayHasKey('title', $response->getOriginalContent()['errors']);
    }

    #[Test]
    public function updating_a_player_pack_item_requires_a_title()
    {

        $user = $this->createUser();
        $tournament = $this->createTournament();
        $user->managing()->save($tournament);

        $this->actingAs($user)
            ->json('POST', '/tournament/player-packs/'.$tournament->id, [
                'title' => 'Test Title',
            ]);

        $playerPack = $tournament->fresh()->playerPacks->first();
        $playerPackItem = $playerPack->items()->create(['title' => 'test']);

        $response = $this->actingAs($user)
            ->json('PUT', '/tournament/player-pack/items/'.$playerPackItem->id);

        $this->assertArrayHasKey('title', $response->getOriginalContent()['errors']);
    }
}
