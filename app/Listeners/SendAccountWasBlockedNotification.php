<?php

namespace App\Listeners;

use App\Events\AccountWasBlocked;
use App\Notifications\AccountBlockedNotification;

final class SendAccountWasBlockedNotification
{
    public function handle(AccountWasBlocked $event): void
    {
        $event->blockedUser->notify(new AccountBlockedNotification($event->blockedUser));
    }
}
