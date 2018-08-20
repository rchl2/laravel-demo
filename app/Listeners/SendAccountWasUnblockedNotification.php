<?php

namespace App\Listeners;

use App\Events\AccountWasUnblocked;
use App\Notifications\AccountUnblockedNotification;

final class SendAccountWasUnblockedNotification
{
    public function handle(AccountWasUnblocked $event): void
    {
        $event->user->notify(new AccountUnblockedNotification($event->user));
    }
}
