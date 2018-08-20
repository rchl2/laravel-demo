<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Front\Account\ConfirmEmailChangeMail;

class AccountRequestEmailChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via(User $user)
    {
        return ['mail'];
    }


    public function toMail(User $user)
    {
        return (new ConfirmEmailChangeMail($this->user))
            ->to($this->user->email(), $this->user->login());
    }
}
