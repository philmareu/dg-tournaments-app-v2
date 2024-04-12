<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            \App\Listeners\Operations\AutoAssignUserToTournaments::class,
            \App\Listeners\Operations\SetupNewUser::class
        ],
        \App\Events\RatingUpdatedEvent::class => [
            \App\Listeners\EmailNotifications\SendRatingUpdatedEmail::class,
            \App\Listeners\Notifications\CreateRatingUpdatedNotification::class,
            \App\Listeners\Activity\CreatePdgaRatingUpdatedActivity::class
        ],
        \App\Events\NewUserActivated::class => [
            \App\Listeners\Notifications\Admin\SendNewUserSlackNotification::class
        ],
        \App\Events\TournamentFollowed::class => [
            \App\Listeners\Activity\CreateTournamentFollowedActivity::class,
        ],
        \App\Events\TournamentUnfollowed::class => [
            \App\Listeners\Activity\CreateTournamentUnfollowedActivity::class
        ],
        \App\Events\TournamentClaimRequestSubmitted::class => [
            \App\Listeners\EmailNotifications\SendClaimRequestEmailToTournament::class,
            \App\Listeners\EmailNotifications\SendClaimRequestConfirmationEmail::class,
            \App\Listeners\Activity\CreateClaimSubmittedActivity::class,
        ],
        \App\Events\TournamentClaimApproved::class => [
            \App\Listeners\Notifications\Admin\SendTournamentClaimedNotification::class,
            \App\Listeners\Notifications\Admin\SendApprovedEmailToClaimRequester::class,
            \App\Listeners\Activity\CreateClaimRequestApprovedActivity::class,
            \App\Listeners\Operations\DeleteClaimRequest::class
        ],
        \App\Events\TournamentSubmitted::class => [
            \App\Listeners\EmailNotifications\SendTournamentSubmittedConfirmationEmail::class,
            \App\Listeners\Activity\CreateTournamentSubmittedActivity::class
        ],
        \App\Events\TournamentRegistrationUpdated::class => [
            \App\Listeners\Activity\CreateTournamentRegistrationUpdatedActivity::class
        ],
        \App\Events\ScheduleSaved::class => [
            \App\Listeners\Activity\CreateScheduleItemSavedActivity::class
        ],
        \App\Events\LinkSaved::class => [
            \App\Listeners\Activity\CreateLinkSavedActivity::class
        ],
        \App\Events\MediaSaved::class => [
            \App\Listeners\Activity\CreateMediaSavedActivity::class
        ],
        \App\Events\PlayerPackItemSaved::class => [
            \App\Listeners\Activity\CreatePlayerPackItemSavedActivity::class
        ],
        \App\Events\CourseCreated::class => [
            \App\Listeners\Activity\CreateCourseCreatedActivity::class
        ],
        \App\Events\TournamentCourseCreated::class => [
            \App\Listeners\Activity\CreateTournamentCourseCreatedActivity::class,
            \App\Listeners\Operations\CheckTournamentLatLng::class
        ],
        \App\Events\OrderPaid::class => [
            \App\Listeners\EmailNotifications\SendOrderConfirmationEmail::class,
            \App\Listeners\Order\CreatePaymentTransfers::class,
        ],
        \App\Events\Models\SponsorshipCreated::class => [
            \App\Listeners\Activity\CreateSponsorshipCreatedActivity::class,
        ],
        \App\Events\Models\TournamentCreated::class => [
            \App\Listeners\Activity\SetDefaultFlags::class,
        ],
        \App\Events\Models\TournamentUpdating::class => [
            \App\Listeners\Activity\CreateTournamentUpdatingActivity::class,
        ],
        \App\Events\TournamentAutoAssigned::class => [
            \App\Listeners\Activity\CreateTournamentAutoAssignedActivity::class
        ],
        \App\Events\Registration\RegistrationOpensSoon::class => [
            \App\Listeners\Activity\CreateTournamentRegistrationOpensSoonActivity::class
        ],
        \App\Events\Registration\RegistrationIsOpen::class => [
            \App\Listeners\Activity\CreateTournamentRegistrationIsOpenActivity::class,
            \App\Listeners\EmailNotifications\SendRegistrationOpenEmail::class
        ],
        \App\Events\Registration\RegistrationClosesSoon::class => [
            \App\Listeners\Activity\CreateTournamentRegistrationClosesSoonActivity::class
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
