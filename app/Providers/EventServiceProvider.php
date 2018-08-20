<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        'App\Events\AccountWasBlocked' => [
            'App\Listeners\SendAccountWasBlockedNotification',
        ],

        'App\Events\AccountWasUnblocked' => [
            'App\Listeners\SendAccountWasUnblockedNotification',
        ],

        'App\Events\AccountRequestedEmailChange' => [
            'App\Listeners\SendAccountRequestEmailChangeNotification',
        ],
    ];
}
