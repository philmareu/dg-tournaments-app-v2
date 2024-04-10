<?php

use Illuminate\Support\Facades\Route;

Route::post('manage/submit', [\App\Http\Controllers\Endpoints\TournamentsEndpointController::class, 'store']);

/*
|--------------------------------------------------------------------------
| /lists
|--------------------------------------------------------------------------
*/

// Special Event Types
Route::get('lists/special-event-types', [\App\Http\Controllers\Endpoints\SpecialEventTypesEndpointController::class, 'list']);

/*
|--------------------------------------------------------------------------
| /tournament
|--------------------------------------------------------------------------
*/

// Poster
Route::put('tournament/poster/{tournament}', 'Tournament\TournamentPosterEndpointController@update');
Route::delete('tournament/poster/{tournament}', 'Tournament\TournamentPosterEndpointController@destroy');

// Stripe
Route::put('tournament/stripe/{tournament}', 'Tournament\TournamentStripeAccountEndpointController@update');
Route::delete('tournament/stripe/{tournament}', 'Tournament\TournamentStripeAccountEndpointController@destroy');

// Registration
Route::post('tournament/registration/{tournament}', [\App\Http\Controllers\Endpoints\RegistrationEndpointController::class, 'store']);
Route::put('tournament/registration/{registration}', [\App\Http\Controllers\Endpoints\RegistrationEndpointController::class, 'update']);

// Surrounding Courses
Route::get('tournament/surrounding-courses/{tournament}', 'Tournament\TournamentSurroundingCoursesEndpointController@get');

// Sponsorships
Route::post('tournament/sponsorships/{tournament}', [\App\Http\Controllers\Endpoints\SponsorshipsEndpointController::class, 'store']);
Route::put('tournament/sponsorships/{sponsorship}', [\App\Http\Controllers\Endpoints\SponsorshipsEndpointController::class, 'update']);
Route::delete('tournament/sponsorships/{sponsorship}', [\App\Http\Controllers\Endpoints\SponsorshipsEndpointController::class, 'destroy']);
//    Route::get('sponsors/{tournament}', [\App\Http\Controllers\Endpoints\SponsorsController::class, 'index']);

// Tournament Sponsors
Route::post('tournament/sponsorship/sponsors/{sponsorship}', [\App\Http\Controllers\Endpoints\TournamentSponsorsEndpointController::class, 'store']);
Route::put('tournament/sponsorship/sponsors/{tournamentSponsor}', [\App\Http\Controllers\Endpoints\TournamentSponsorsEndpointController::class, 'update']);
Route::delete('tournament/sponsorship/sponsors/{tournamentSponsor}', [\App\Http\Controllers\Endpoints\TournamentSponsorsEndpointController::class, 'destroy']);

// Player Packs
Route::post('tournament/player-packs/{tournament}', [\App\Http\Controllers\Endpoints\PlayerPacksEndpointController::class, 'store']);
Route::put('tournament/player-packs/{playerPack}', [\App\Http\Controllers\Endpoints\PlayerPacksEndpointController::class, 'update']);
Route::delete('tournament/player-packs/{playerPack}', [\App\Http\Controllers\Endpoints\PlayerPacksEndpointController::class, 'destroy']);

// Player Packs Items
Route::post('tournament/player-pack/items/{playerPack}', [\App\Http\Controllers\Endpoints\PlayerPackItemsEndpointController::class, 'store']);
Route::put('tournament/player-pack/items/{playerPackItem}', [\App\Http\Controllers\Endpoints\PlayerPackItemsEndpointController::class, 'update']);
Route::delete('tournament/player-pack/items/{playerPackItem}', [\App\Http\Controllers\Endpoints\PlayerPackItemsEndpointController::class, 'destroy']);

// Course
Route::get('tournament/courses/{tournamentCourse}', [\App\Http\Controllers\Endpoints\TournamentCoursesEndpointController::class, 'show']);
Route::post('tournament/courses/{tournament}', [\App\Http\Controllers\Endpoints\TournamentCoursesEndpointController::class, 'store']);
Route::put('tournament/courses/{tournamentCourse}', [\App\Http\Controllers\Endpoints\TournamentCoursesEndpointController::class, 'update']);
Route::delete('tournament/courses/{tournamentCourse}', [\App\Http\Controllers\Endpoints\TournamentCoursesEndpointController::class, 'destroy']);
Route::put('tournament/course/holes/{tournamentCourse}', [\App\Http\Controllers\Endpoints\TournamentCoursesEndpointController::class, 'holes']);

// Schedule
Route::get('tournament/schedule/{tournament}', [\App\Http\Controllers\Endpoints\ScheduleEndpointController::class, 'get']);
Route::post('tournament/schedule/{tournament}', [\App\Http\Controllers\Endpoints\ScheduleEndpointController::class, 'store']);
Route::put('tournament/schedule/{schedule}', [\App\Http\Controllers\Endpoints\ScheduleEndpointController::class, 'update']);
Route::delete('tournament/schedule/{schedule}', [\App\Http\Controllers\Endpoints\ScheduleEndpointController::class, 'destroy']);

// Link
Route::post('tournament/links/{tournament}', [\App\Http\Controllers\Endpoints\LinksEndpointController::class, 'store']);
Route::put('tournament/links/{link}', [\App\Http\Controllers\Endpoints\LinksEndpointController::class, 'update']);
Route::delete('tournament/links/{link}', [\App\Http\Controllers\Endpoints\LinksEndpointController::class, 'destroy']);

// Media
Route::post('tournament/media/{tournament}', [\App\Http\Controllers\Endpoints\MediaEndpointController::class, 'store']);
Route::put('tournament/media/{tournament}', [\App\Http\Controllers\Endpoints\MediaEndpointController::class, 'update']);
Route::delete('tournament/media/{tournament}/{upload_id}', [\App\Http\Controllers\Endpoints\MediaEndpointController::class, 'destroy']);

// Claim
Route::post('tournament/claim/{tournament}', [\App\Http\Controllers\Endpoints\UserClaimEndpointController::class, 'claim']);

// Basic
Route::get('tournament/{tournament}', [\App\Http\Controllers\Endpoints\TournamentsEndpointController::class, 'index']);
Route::post('tournament', [\App\Http\Controllers\Endpoints\TournamentsEndpointController::class, 'store']);
Route::put('tournament/{tournament}', [\App\Http\Controllers\Endpoints\TournamentsEndpointController::class, 'update']);

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

// Sponsors
Route::get('user/sponsors', [\App\Http\Controllers\Endpoints\UserSponsorsEndpointController::class, 'list']);
Route::post('user/sponsors', [\App\Http\Controllers\Endpoints\UserSponsorsEndpointController::class, 'store']);
Route::put('user/sponsors/{sponsor}', [\App\Http\Controllers\Endpoints\UserSponsorsEndpointController::class, 'update']);
Route::delete('user/sponsors/{sponsor}', [\App\Http\Controllers\Endpoints\UserSponsorsEndpointController::class, 'destroy']);

// Follow
Route::put('user/follow/tournament/{tournament}', [\App\Http\Controllers\Endpoints\UserFollowsEndpointController::class, 'tournament']);

// Uploads
Route::post('user/upload', [\App\Http\Controllers\Endpoints\UserFilesEndpointController::class, 'upload']);

// Payment Methods
Route::get('user/credit-cards', [\App\Http\Controllers\Endpoints\UserEndpointController::class, 'getCards']);
Route::post('user/stripe/customer', [\App\Http\Controllers\Endpoints\UserEndpointController::class, 'createCustomer']);
Route::post('user/stripe/card', [\App\Http\Controllers\Endpoints\UserEndpointController::class, 'addCard']);
Route::delete('user/stripe/card/{cardId}', [\App\Http\Controllers\Endpoints\UserEndpointController::class, 'removeCard']);

// Search
Route::post('user/searches', [\App\Http\Controllers\Endpoints\UserSearchEndpointController::class, 'store']);
Route::put('user/searches/{search}', [\App\Http\Controllers\Endpoints\UserSearchEndpointController::class, 'update']);
Route::delete('user/searches/{search}', [\App\Http\Controllers\Endpoints\UserSearchEndpointController::class, 'destroy']);

// Stripe
Route::delete('user/stripe/{stripeAccount}', [\App\Http\Controllers\Endpoints\UserStripeEndpointController::class, 'destroy']);

// Feed
Route::get('user/feed', [\App\Http\Controllers\Endpoints\UserFeedController::class, 'index']);

/*
|--------------------------------------------------------------------------
| ORDER
|--------------------------------------------------------------------------
*/

Route::get('order/current', \App\Http\Controllers\Endpoints\OrderCurrentEndpointController::class);
Route::put('order/sponsorships/{sponsorship}', [\App\Http\Controllers\Endpoints\OrderEndpointController::class, 'addSponsorship']);
Route::delete('order/sponsorships/{orderSponsorship}', [\App\Http\Controllers\Endpoints\OrderEndpointController::class, 'destroySponsorship']);

// Checkout
Route::put('order/checkout/details', [\App\Http\Controllers\Endpoints\OrderEndpointController::class, 'processDetails']);
Route::post('order/checkout/pay', [\App\Http\Controllers\Endpoints\OrderEndpointController::class, 'pay']);

Route::post('order/refund/{transfer}', [\App\Http\Controllers\Endpoints\ManageOrderEndpointController::class, 'refund']);

/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

Route::get('cache/bounds/{map?}', [\App\Http\Controllers\Endpoints\MapBoundsEndpointController::class, 'getBounds']);
Route::put('cache/bounds/{map?}', [\App\Http\Controllers\Endpoints\MapBoundsEndpointController::class, 'setBounds']);
