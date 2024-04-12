<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Format;
use App\Models\PdgaTier;
use App\Models\Schedule;
use App\Models\SpecialEventType;
use App\Models\Sponsorship;
use App\Models\StripeAccount;
use App\Models\Tournament;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TournamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = Classes::all();
        $pdgaTiers = PdgaTier::all();
        $formats = Format::all();
        $specialEventTypes = SpecialEventType::all();

        $names = [
            'Windstorm Open',
            'Green Meadow Sunshine Series',
            'Frozen Lake Open',
            'Trees Be Damned Breaker Series',
            'Windy Brush Open',
            '2018 Free the Disc Series Opener',
        ];

        foreach ($names as $name) {
            $tournament = Tournament::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
                'poster_id' => null,
                'format_id' => 1,
            ]);

            $tournament->format()->associate($formats->random());
            $tournament->specialEventTypes()->saveMany($specialEventTypes->random(rand(1, 2)));
            $tournament->classes()->saveMany($classes->random(rand(1, 2)));
            $tournament->save();
        }

        //        $tournament = Tournament::factory()->create([
        //            'name' => 'DGT Open Unsanctioned',
        //            'slug' => 'dgt-open-unsanctioned',
        //            'poster_id' => null
        //        ]);
        //
        //        $tournament->managers()->save(User::find(1));
        //        $tournament->stripeAccount()->associate(StripeAccount::find(1))->save();
        //        $tournament->format()->associate($formats->random());
        //        $tournament->specialEventTypes()->saveMany($specialEventTypes->random(rand(0, 2)));
        //        $tournament->classes()->saveMany($classes->random(rand(1, 3)));
        //        $tournament->save();

        //        $playerPack = TournamentPlayerPack::factory()->make();
        //        $tournament->playerPacks()->save($playerPack);
        //        $playerPack->items()->save(TournamentPlayerPackItem::factory()->make());
        //        $playerPack->items()->save(TournamentPlayerPackItem::factory()->make());
        //        $playerPack->items()->save(TournamentPlayerPackItem::factory()->make());
        //        $tournament->schedule()->save(TournamentSchedule::factory()->create());
        //        $tournament->schedule()->save(TournamentSchedule::factory()->create());
        //        $tournament->schedule()->save(TournamentSchedule::factory()->create());
        //        $tournament->schedule()->save(TournamentSchedule::factory()->create());
        //        $tournament->sponsorships()->save(Sponsorship::factory()->create());
        //        $tournament->sponsorships()->save(Sponsorship::factory()->create());

        //        factory(Tournament::class, 40)->create(['format_id' => rand(1, 5)])->each(function(Tournament $tournament) use ($formats, $pdgaTiers, $specialEventTypes, $classes) {
        //            $tournament->format()->associate($formats->first());
        //            $tournament->pdgaTiers()->save($pdgaTiers->first());
        //            $tournament->specialEventTypes()->save($specialEventTypes->first());
        //            $tournament->classes()->save($classes->first());
        //            $tournament->save();
        //        });
    }
}
