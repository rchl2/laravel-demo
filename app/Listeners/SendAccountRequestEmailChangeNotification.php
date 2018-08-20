<?php

namespace App\Listeners;

use App\Events\AccountRequestedEmailChange;
use App\Notifications\AccountRequestEmailChangeNotification;

final class SendAccountRequestEmailChangeNotification
{
    public function handle(AccountRequestedEmailChange $event): void
    {
        $event->user->notify(new AccountRequestEmailChangeNotification($event->user));
    }
}
