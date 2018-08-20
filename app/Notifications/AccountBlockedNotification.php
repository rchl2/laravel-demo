<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Admin\Account\AccountBlockedMail;

final class AccountBlockedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $blockedUser;

    public function __construct(User $blockedUser)
    {
        $this->blockedUser = $blockedUser;
    }

    public function via(User $user)
    {
        return ['mail'];
    }

    public function toMail(User $user)
    {
        return (new AccountBlockedMail($this->blockedUser))
            ->to($this->blockedUser->email(), $this->blockedUser->login());
    }
}
