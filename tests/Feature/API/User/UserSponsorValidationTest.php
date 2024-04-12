<?php

namespace Tests\Feature\API\User;

use App\Models\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserSponsorValidationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function storing_a_sponsor_requires_a_title()
    {
        $this->storing('title');
    }

    #[Test]
    public function storing_a_sponsor_requires_a_valid_url()
    {
        $this->storing('url', ['url' => 'Not a valid url']);
    }

    #[Test]
    public function storing_a_sponsor_requires_a_upload_id_that_exists()
    {
        $this->storing('upload_id', ['upload_id' => 1]);
    }

    #[Test]
    public function updating_a_sponsor_requires_a_title()
    {
        $this->updating('title');
    }

    #[Test]
    public function updating_a_sponsor_requires_a_valid_url()
    {
        $this->updating('url', ['url' => 'Not a valid url']);
    }

    #[Test]
    public function updating_a_sponsor_requires_a_upload_id_that_exists_if_submitted()
    {
        $this->updating('upload_id', ['upload_id' => 10]);
    }

    private function storing($key, $data = [])
    {
        $this->actingAs($this->createUser())
            ->call('POST', 'user/sponsors', $data)
            ->assertSessionHasErrors($key);
    }

    private function updating($key, $data = [])
    {
        $user = $this->createUser();
        $sponsor = Sponsor::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->call('PUT', 'user/sponsors/'.$sponsor->id, $data)
            ->assertSessionHasErrors($key);
    }
}
