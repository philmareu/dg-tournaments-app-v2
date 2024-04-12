<?php

namespace Database\Seeders;

use App\Models\Charge;
use App\Models\Order;
use App\Models\OrderSponsorship;
use App\Models\Sponsor;
use App\Models\StripeAccount;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Dev',
            'email' => 'dev@dev.com',
            'password' => bcrypt('password'),
            'activated' => 1,
            'is_admin' => 1,
        ]);

        $user->stripeAccounts()->save(StripeAccount::factory()->make([
            'display_name' => 'Test Account 1',
            'stripe_user_id' => env('STRIPE_TEST_ACCOUNT_1_ACCOUNT', 1),
        ]));
        $user->stripeAccounts()->save(StripeAccount::factory()->make([
            'display_name' => 'Test Account 2',
            'stripe_user_id' => env('STRIPE_TEST_ACCOUNT_2_ACCOUNT', 2),
        ]));

        //        $user->sponsors()->save(Sponsor::factory()->create());
        //        $user->sponsors()->save(Sponsor::factory()->create());
        //        $user->sponsors()->save(Sponsor::factory()->create());
        //
        //        $order = Order::factory()->states('paid')->create(['user_id' => $user->id]);
        //        $order->sponsorships()->saveMany(factory(OrderSponsorship::class, 2)->create());
        //        Charge::factory()->states('successful')->create(['order_id' => $order->id]);
        //
        //        $order = Order::factory()->states('paid')->create(['user_id' => $user->id]);
        //        $order->sponsorships()->saveMany(factory(OrderSponsorship::class, 2)->create());
        //        Charge::factory()->states('successful')->create(['order_id' => $order->id]);
    }
}
