<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PAGES
|--------------------------------------------------------------------------
*/

// Primary
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Tournament
Route::get('disc-golf-tournament/{tournament}/{slug}/{section?}', [\App\Http\Controllers\TournamentsController::class, 'index']);

// Auth
Route::get('auth/facebook', [\App\Http\Controllers\Auth\FacebookAuthController::class, 'redirectToProvider'])->name('auth.facebook');
Route::get('auth/facebook/callback', [\App\Http\Controllers\Auth\FacebookAuthController::class, 'handleProviderCallback']);
Route::get('auth/twitter', [\App\Http\Controllers\Auth\TwitterAuthController::class, 'redirectToProvider'])->name('auth.twitter');
Route::get('auth/twitter/callback', [\App\Http\Controllers\Auth\TwitterAuthController::class, 'handleProviderCallback']);
Auth::routes();
Route::get('user/activation/{token}', [\App\Http\Controllers\Auth\RegisterController::class, 'activateUser'])->name('user.activate');

// Basic
Route::get('about', [\App\Http\Controllers\PagesController::class, 'about']);
Route::get('terms-of-service', [\App\Http\Controllers\PagesController::class, 'page']);
Route::get('privacy-policy', [\App\Http\Controllers\PagesController::class, 'page']);
Route::get('contact-us', [\App\Http\Controllers\FeedbacksController::class, 'index']);
Route::post('contact-us', [\App\Http\Controllers\FeedbacksController::class, 'store']);
Route::get('tournament/claim/confirm/{token}', [\App\Http\Controllers\User\ClaimController::class, 'viewClaim']);
Route::post('tournament/claim/confirm/{token}', [\App\Http\Controllers\User\ClaimController::class, 'processClaim']);
Route::get('invite/{code}', [\App\Http\Controllers\User\ReferralsController::class, 'invite'])->middleware('guest');
Route::get('tournament', [\App\Http\Controllers\TournamentsController::class, 'submit']);

// Cart/Checkout
Route::get('checkout', [\App\Http\Controllers\CheckoutController::class, 'index']);

// Blog
Route::get('blog', [\App\Http\Controllers\BlogController::class, 'index']);
Route::get('blog/{year}/{month}/{day}/{slug}', [\App\Http\Controllers\BlogController::class, 'show']);

/*
|--------------------------------------------------------------------------
| ENDPOINTS
|--------------------------------------------------------------------------
*/

include 'endpoints.php';

Route::get('user/current', [\App\Http\Controllers\UsersController::class, 'current']);
Route::get('api/weather/{tournament}', [\App\Http\Controllers\WeatherController::class, 'tournament']);

/*
|--------------------------------------------------------------------------
| ACCOUNT
|--------------------------------------------------------------------------
*/

Route::get('account/profile', [\App\Http\Controllers\Account\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('account/profile', [\App\Http\Controllers\Account\ProfileController::class, 'update'])->name('profile.update');
Route::get('account/settings', [\App\Http\Controllers\Account\SettingsController::class, 'edit'])->name('account.settings');
Route::put('account/settings', [\App\Http\Controllers\Account\SettingsController::class, 'update'])->name('account.settings.update');
Route::get('account/memberships', [\App\Http\Controllers\Account\MembershipsController::class, 'edit'])->name('account.memberships');
Route::put('account/memberships', [\App\Http\Controllers\Account\MembershipsController::class, 'update'])->name('account.memberships.update');
Route::get('account/orders', [\App\Http\Controllers\Account\OrdersController::class, 'index'])->name('account.orders');
Route::get('account/orders/{order}', [\App\Http\Controllers\Account\OrdersController::class, 'show'])->name('account.orders.show');
Route::get('account/billing', [\App\Http\Controllers\Account\BillingController::class, 'index']);
Route::get('account/notifications', [\App\Http\Controllers\Account\EmailNotificationsController::class, 'index'])->name('account.notifications');
Route::put('account/notifications', [\App\Http\Controllers\Account\EmailNotificationsController::class, 'update']);
Route::get('account/referral', [\App\Http\Controllers\User\ReferralsController::class, 'create'])->name('referral.create');
Route::post('account/referral', [\App\Http\Controllers\User\ReferralsController::class, 'store'])->name('referral.store');

/*
|--------------------------------------------------------------------------
| MANAGE
|--------------------------------------------------------------------------
*/

// Manage Tools
Route::get('manage', [\App\Http\Controllers\User\TournamentManagerController::class, 'index'])->name('manage.index');
Route::get('manage/sponsors', [\App\Http\Controllers\User\TournamentManagerController::class, 'sponsors'])->name('manage.sponsor-library');
Route::get('manage/submit', [\App\Http\Controllers\User\TournamentManagerController::class, 'submit'])->name('manage.submit');
Route::get('manage/stripe', [\App\Http\Controllers\User\TournamentManagerController::class, 'stripe'])->name('manage.stripe-accounts');
Route::get('manage/stripe/connect', [\App\Http\Controllers\User\TournamentManagerController::class, 'connect']);

// Manage Tournament
Route::get('manage/{tournament}/order/{transfer}', [\App\Http\Controllers\User\ManageTournamentController::class, 'order'])->name('manage.tournament.order');
Route::get('manage/{tournament}/sponsors', [\App\Http\Controllers\User\ManageTournamentController::class, 'sponsors'])->name('manage.tournament.sponsors');
Route::get('manage/{tournament}/credit-card', [\App\Http\Controllers\User\ManageTournamentController::class, 'creditCard'])->name('manage.tournament.credit-card');
Route::get('manage/{tournament}/orders', [\App\Http\Controllers\User\ManageTournamentController::class, 'orders'])->name('manage.tournament.orders');
Route::get('manage/{tournament}/followers', [\App\Http\Controllers\User\ManageTournamentController::class, 'followers'])->name('manage.tournament.followers');
Route::get('manage/{tournament}/basics', [\App\Http\Controllers\User\ManageTournamentController::class, 'basics'])->name('manage.tournament.basics');
Route::get('manage/{tournament}/course/{tournamentCourse}', [\App\Http\Controllers\User\ManageTournamentController::class, 'course'])->name('manage.tournament.course');
Route::get('manage/{tournament}/sponsorship/{sponsorship}', [\App\Http\Controllers\User\ManageTournamentController::class, 'sponsorship'])->name('manage.tournament.sponsorship');
Route::get('manage/{tournament}/registration', [\App\Http\Controllers\User\ManageTournamentController::class, 'registration'])->name('manage.tournament.registration');
Route::get('manage/{tournament}/schedule', [\App\Http\Controllers\User\ManageTournamentController::class, 'schedule'])->name('manage.tournament.schedule');
Route::get('manage/{tournament}/links', [\App\Http\Controllers\User\ManageTournamentController::class, 'links'])->name('manage.tournament.links');
Route::get('manage/{tournament}/media', [\App\Http\Controllers\User\ManageTournamentController::class, 'media'])->name('manage.tournament.media');
Route::get('manage/{tournament}/player-packs', [\App\Http\Controllers\User\ManageTournamentController::class, 'playerPacks'])->name('manage.tournament.player-packs');
Route::get('manage/{tournament}', [\App\Http\Controllers\User\ManageTournamentController::class, 'basics'])->name('manage.tournament.index');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::get('blog/preview/{id}', [\App\Http\Controllers\BlogController::class, 'preview'])->middleware('admin');

Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::get('tournaments/future', [\App\Http\Controllers\TournamentsController::class, 'future']);
    Route::get('tournaments/flagged', [\App\Http\Controllers\TournamentsController::class, 'flagged']);
    Route::get('sessions', [\App\Http\Controllers\Admin\SessionsController::class, 'index']);
    Route::resource('tournaments', 'TournamentsController', ['only' => ['index', 'edit', 'update', 'show']]);
    Route::post('flags/{flag}/postpone/{days}', [\App\Http\Controllers\Admin\FlagsController::class, 'postpone']);
});
