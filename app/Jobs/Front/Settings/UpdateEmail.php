<?php

namespace App\Jobs\Front\Settings;

use App\Models\User;

final class UpdateEmail
{
    private $user;
    private $email;

    public function __construct(User $user, string $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    public function handle()
    {
        return $this->user->update(['email' => $this->email, 'new_email' => null, 'new_email_token' => null]);
    }
}
