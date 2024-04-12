<?php

namespace Tests\Feature\API\Tournament;

use App\Models\Tournament;
use App\Models\Upload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MediaEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    #[Test]
    public function only_a_manager_can_store_a_upload()
    {

        $this->actingAs($this->createUser())
            ->json('POST', 'tournament/media/'.Tournament::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function only_a_manager_can_update_a_upload()
    {

        $this->actingAs($this->createUser())
            ->json('PUT', 'tournament/media/'.Tournament::factory()->create()->id)
            ->assertStatus(403);
    }

    #[Test]
    public function only_a_manager_can_delete_a_upload()
    {
        $tournament = $this->createTournament();
        $upload = Upload::factory()->create();
        $tournament->media()->attach($upload->id);

        $this->actingAs($this->createUser())
            ->json('DELETE', 'tournament/media/'.$tournament->id.'/'.$upload->id)
            ->assertStatus(403);
    }

    #[Test]
    public function manager_can_store_a_new_media_file()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $upload = Upload::factory()->create();

        $data = [
            'title' => 'Upload Title',
            'uploaded_id' => $upload->id,
        ];

        $this->actingAs($user)
            ->json('POST', 'tournament/media/'.$tournament->id, $data)
            ->assertJson([
                [
                    'id' => $upload->id,
                    'title' => 'Upload Title',
                ],
            ]);

        $this->assertDatabaseHas('media', [
            'tournament_id' => $tournament->id,
            'upload_id' => $upload->id,
        ]);
    }

    #[Test]
    public function manager_can_update_a_media_file()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $upload = Upload::factory()->create();
        $tournament->media()->save($upload);

        $newUpload = Upload::factory()->create();

        $data = [
            'title' => 'Upload Title',
            'id' => $upload->id,
            'uploaded_id' => $newUpload->id,
        ];

        $this->actingAs($user)
            ->json('PUT', 'tournament/media/'.$tournament->id, $data)
            ->assertJson([
                [
                    'id' => $newUpload->id,
                    'title' => 'Upload Title',
                ],
            ]);

        $this->assertDatabaseHas('media', [
            'tournament_id' => $tournament->id,
            'upload_id' => $newUpload->id,
        ]);
    }

    #[Test]
    public function manager_can_delete_a_media_item()
    {
        [$user, $tournament] = $this->createTournamentWithManager();

        $upload = Upload::factory()->create();

        $tournament->media()->save($upload);

        $this->actingAs($user)
            ->json('DELETE', 'tournament/media/'.$tournament->id.'/'.$upload->id)
            ->assertJson([]);

        $this->assertDatabaseMissing('media', [
            'upload_id' => $upload->id,
            'tournament_id' => $tournament->id,
        ]);
    }
}
