<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

final class AccountWasUnblocked
{
    use SerializesModels;

    public $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
