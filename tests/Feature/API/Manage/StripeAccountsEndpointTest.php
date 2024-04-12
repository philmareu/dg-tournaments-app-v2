<?php

namespace Tests\Feature\API\Manage;

use App\Models\StripeAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StripeAccountsEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = 'user/stripe';

    #[Test]
    public function guests_can_not_remove_user_stripe_accounts()
    {
        $this->json('DELETE', $this->endpoint.'/'.StripeAccount::factory()->create()->id)
            ->assertStatus(401);
    }

    #[Test]
    public function only_the_owner_can_remove_the_stripe_account()
    {
        $stripeAccount = StripeAccount::factory()->create();

        $this->actingAs($this->createUser())
            ->json('DELETE', $this->endpoint.'/'.$stripeAccount->id)
            ->assertStatus(403);
    }

    #[Test]
    public function authenticated_user_can_remove_their_stripe_account()
    {
        $stripeAccount = StripeAccount::factory()->create();

        $this->actingAs($stripeAccount->user)
            ->json('DELETE', $this->endpoint.'/'.$stripeAccount->id);

        $this->assertDatabaseMissing('stripe_accounts', [
            'user_id' => $stripeAccount->user_id,
            'id' => $stripeAccount->id,
        ]);
    }

    #[Test]
    public function fresh_list_of_stripe_accounts_is_returned()
    {
        $user = $this->createUser();
        $stripeAccount1 = StripeAccount::factory()->create();
        $stripeAccount2 = StripeAccount::factory()->create();
        $stripeAccount3 = StripeAccount::factory()->create();

        $user->stripeAccounts()->save($stripeAccount1);
        $user->stripeAccounts()->save($stripeAccount2);

        $this->actingAs($user)
            ->json('DELETE', $this->endpoint.'/'.$stripeAccount1->id)
            ->assertJson([
                [
                    'id' => $stripeAccount2->id,
                ],
            ])
            ->assertJsonMissing([
                [
                    'id' => $stripeAccount1->id,
                ],
                [
                    'id' => $stripeAccount3->id,
                ],
            ]);
    }
}
