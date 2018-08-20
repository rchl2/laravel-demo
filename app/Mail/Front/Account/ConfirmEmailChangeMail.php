<?php

namespace App\Mail\Front\Account;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class ConfirmEmailChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('mail.account.email')
                ->subject(trans('mails/mails.account_change_email.subject'));
    }
}
