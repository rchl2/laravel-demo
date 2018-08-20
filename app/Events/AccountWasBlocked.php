<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

final class AccountWasBlocked
{
    use SerializesModels;

    public $blockedUser;

    public function __construct(User $blockedUser)
    {
        $this->blockedUser = $blockedUser;
    }
}
