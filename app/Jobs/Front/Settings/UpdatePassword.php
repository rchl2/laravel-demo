<?php

namespace App\Jobs\Front\Settings;

use App\Models\User;

final class UpdatePassword
{
    private $user;
    private $password;
    private $accountService;

    public function __construct(User $user, string $password, $accountService)
    {
        $this->user = $user;
        $this->password = $password;
        $this->accountService = $accountService;
    }

    public function handle()
    {
        return $this->user->update(['password' => $this->accountService->makeHashFromString($this->password)]);
    }
}
