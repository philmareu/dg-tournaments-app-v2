<?php

namespace Tests\Feature\API\User;

use App\Events\TournamentFollowed;
use App\Events\TournamentUnfollowed;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TournamentFollowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_follow_a_tournament()
    {
        $tournament = $this->createTournament();

        $this->assertFalse(Auth::check());
        $response = $this->json('PUT', 'user/follow/tournament/'.$tournament->id);
        $response->assertStatus(401);
    }

    #[Test]
    public function user_can_follow_a_tournament()
    {
        [$user, $tournament] = $this->createUserFollowTournament();

        $followingTournament = $user->following()
            ->where('resource_type', 'App\Models\Tournament')
            ->where('resource_id', $tournament->id)
            ->first();

        $this->assertEquals($tournament->id, $followingTournament->id);
    }

    #[Test]
    public function user_model_is_returned_with_following_relationship_after_a_follow()
    {
        $user = $this->createUser();
        $tournament = $this->createTournament();

        $this->actingAs($user)
            ->json('PUT', '/user/follow/tournament/'.$tournament->id)
            ->assertJson([
                'following' => [],
            ]);
    }

    #[Test]
    public function user_can_unfollow_a_tournament()
    {
        [$user, $tournament] = $this->createUserFollowTournament();
        $this->followTournament($user, $tournament);

        $followingTournament = $user->following()
            ->where('resource_type', 'App\Models\Tournament')
            ->where('resource_id', $tournament->id)
            ->first();

        $this->assertEquals(null, $followingTournament);
    }

    #[Test]
    public function followed_tournament_event_is_fired()
    {
        $user = $this->createUser();
        $tournament = $this->createTournament();
        Event::fake();

        $this->followTournament($user, $tournament);

        Event::assertDispatched(TournamentFollowed::class, function ($e) use ($tournament) {
            return $e->follow->resource->id === $tournament->id;
        });
    }

    #[Test]
    public function unfollowed_tournament_event_is_fired()
    {
        [$user, $tournament] = $this->createUserFollowTournament();

        Event::fake();
        $this->followTournament($user, $tournament);

        Event::assertDispatched(TournamentUnfollowed::class, function ($e) use ($tournament) {
            return $e->tournament->id === $tournament->id;
        });
    }

    #[Test]
    public function an_activity_is_created_when_tournament_is_followed()
    {
        [$user, $tournament] = $this->createUserFollowTournament();

        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'resource_type' => 'App\Models\Tournament',
            'resource_id' => $tournament->id,
            'type' => 'tournament.followed',
        ]);
    }

    #[Test]
    public function an_activity_is_created_when_tournament_is_unfollowed()
    {
        [$user, $tournament] = $this->createUserFollowTournament();
        $this->followTournament($user, $tournament);

        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'resource_type' => 'App\Models\Tournament',
            'resource_id' => $tournament->id,
            'type' => 'tournament.unfollowed',
        ]);
    }

    #[Test]
    public function user_model_provides_a_list_of_following_tournaments()
    {
        $user = $this->createUser();
        $tournament = $this->createTournament();
        $this->followTournament($user, $tournament);

        $tournament = $this->createTournament();
        $this->followTournament($user, $tournament);

        $tournament = $this->createTournament();
        $this->followTournament($user, $tournament);

        $this->assertInstanceOf(Collection::class, $user->followingTournaments);
        $this->assertEquals(3, $user->followingTournaments->count());
    }

    public function followTournament($user, $tournament)
    {
        $response = $this->actingAs($user)
            ->json('PUT', '/user/follow/tournament/'.$tournament->id);
    }

    /**
     * @return array
     */
    public function createUserFollowTournament()
    {
        $user = $this->createUser();
        $tournament = $this->createTournament();
        $this->followTournament($user, $tournament);

        return [$user, $tournament];
    }

    //    public function creating_tournament_followed_activity_is_queued()
    //    {
    //        $user = $this->createUser();
    //        $tournament = $this->createTournament();
    //
    //        Queue::fake();
    //
    //        $this->followTournament($user, $tournament);
    //
    //        Queue::assertPushed(\App\Listeners\Activity\CreateTournamentFollowedActivity::class, function ($job) use ($tournament, $user) {
    //            return $job->tournament->id === $tournament->id && $job->user->id === $user->id;
    //        });
    //    }
}
