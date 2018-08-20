<?php

namespace App\Mail\Admin\Account;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountBlockedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $blockedUser;

    public function __construct(User $blockedUser)
    {
        $this->blockedUser = $blockedUser;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('mail.account.block')
                ->subject(trans('mails/mails.account_blocked.subject'));
    }
}
