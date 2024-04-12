<?php

namespace Tests\Unit;

use App\Models\ClaimRequest;
use App\Repositories\ClaimRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClaimRepositoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function token_created()
    {
        $repo = $this->getRepo();

        $this->assertEquals('string', gettype($repo->createToken()));
    }

    #[Test]
    public function should_be_false_if_there_is_no_existing_claim_request()
    {
        $repo = $this->getRepo();
        $tournament = $this->createTournament();

        $this->assertFalse($repo->tournamentAlreadyHasRequest($tournament));
    }

    #[Test]
    public function should_be_true_if_there_is_an_existing_claim_request()
    {
        $repo = $this->getRepo();
        $tournament = $this->createTournament();

        $claim = ClaimRequest::factory()->make();
        $claim->tournament()->associate($tournament);
        $claim->save();

        $this->assertTrue($repo->tournamentAlreadyHasRequest($tournament));
    }

    #[Test]
    public function should_be_true_if_user_already_can_manage_this_tournament()
    {
        $repo = $this->getRepo();
        $user = $this->createUser();
        $tournament = $this->createTournament();
        $tournament->managers()->save($user);

        $this->assertTrue($repo->userAlreadyManages($tournament, $user));
    }

    #[Test]
    public function should_be_false_if_user_cannot_manager_this_tournament()
    {
        $repo = $this->getRepo();
        $user = $this->createUser();
        $tournament = $this->createTournament();

        $this->assertFalse($repo->userAlreadyManages($tournament, $user));
    }

    /**
     * @return ClaimRepository
     */
    public function getRepo()
    {
        return new ClaimRepository(new ClaimRequest());
    }
}
