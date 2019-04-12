<?php

namespace App\Providers;

use App\Events\RequestWasAccepted;
use App\Events\UserWasRegistered;
use App\Events\UserWasRequested;
use App\Events\SendAppNotification;
use App\Listeners\EmailNotifier;
use App\Listeners\RequestAcceptanceNotifier;
use App\Listeners\RequestNotifier;
use App\Listeners\AppNotificationNotifier;
use App\Events\FollowRequestNotification;
use App\Listeners\FollowRequestNotificationNotifier;
use App\Listeners\StoreSetting;
use App\Events\StartFollowingNotification;
use App\Listeners\StartFollowingNotificationNotifier;
use App\Events\FollowAcceptanceNotification;
use App\Listeners\FollowAcceptanceNotificationNotifier;
use App\Events\EventInviteAndTagNotification;
use App\Listeners\EventInviteAndTagNotificationNotifier;
use App\Events\PostCommentNotification;
use App\Listeners\PostCommentNotificationNotifier;
use App\Events\PostRateNotification;
use App\Listeners\PostRateNotificationNotifier;
use App\Events\SocialPostContent;
use App\Listeners\SocialPostContentNotifier;
use App\Events\GroupInvitationWasSent;
use App\Listeners\GroupInvitationSentNotifier;
use App\Listeners\GroupInvitationSentNotificationNotifier;
use App\Events\UserWasJoinedGroup;
use App\Listeners\UserJoinedGroupNotifier;
use App\Listeners\UserJoinedGroupNotificationNotifier;
use App\Events\GroupJoinRequestWasSent;
use App\Listeners\GroupJoinRequestNotifier;
use App\Listeners\GroupJoinRequestNotificationNotifier;
use App\Events\GroupInvitationWasAccepted;
use App\Listeners\GroupInvitationAcceptedNotifier;
use App\Listeners\GroupInvitationAcceptedNotificationNotifier;
use App\Events\GroupWasCreated;
use App\Listeners\StoreGroupSetting;
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
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        UserWasRegistered::class => [
            StoreSetting::class,
            EmailNotifier::class
        ],
        UserWasRequested::class => [
            RequestNotifier::class
        ],
        RequestWasAccepted::class => [
            RequestAcceptanceNotifier::class
        ],
        SendAppNotification::class => [
            AppNotificationNotifier::class
        ],
        FollowRequestNotification::class => [
            FollowRequestNotificationNotifier::class
        ],
        StartFollowingNotification::class => [
            StartFollowingNotificationNotifier::class
        ],
        FollowAcceptanceNotification::class => [
          FollowAcceptanceNotificationNotifier::class
        ],
        EventInviteAndTagNotification::class => [
          EventInviteAndTagNotificationNotifier::class
        ],
        PostCommentNotification::class => [
            PostCommentNotificationNotifier::class
        ],
        PostRateNotification::class => [
            PostRateNotificationNotifier::class
        ],
        GroupInvitationWasSent::class=>[
            GroupInvitationSentNotifier::class,
            GroupInvitationSentNotificationNotifier::class
        ],
        UserWasJoinedGroup::class=>[
            UserJoinedGroupNotifier::class,
            UserJoinedGroupNotificationNotifier::class
        ],
        GroupJoinRequestWasSent::class=>[
            GroupJoinRequestNotifier::class,
            GroupJoinRequestNotificationNotifier::class
        ],
        GroupInvitationWasAccepted::class=>[
            GroupInvitationAcceptedNotifier::class,
            GroupInvitationAcceptedNotificationNotifier::class
        ],
        GroupWasCreated::class=>[
            StoreGroupSetting::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
