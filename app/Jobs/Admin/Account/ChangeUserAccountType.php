<?php

namespace App\Jobs\Admin\Account;

use App\Models\User;

final class ChangeUserAccountType
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): bool
    {
        return ($this->user->isAdmin()) ? $this->user->update(['web_admin' => 0]) : $this->user->update(['web_admin' => 1]);
    }
}
