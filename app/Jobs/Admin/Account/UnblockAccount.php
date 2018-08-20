<?php

namespace App\Jobs\Admin\Account;

use Carbon\Carbon;
use App\Models\User;
use App\Events\AccountWasUnblocked;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\Admin\FailedAttempts\DeleteFailedAttempt;

final class UnblockAccount
{
    use DispatchesJobs;

    // Status of account
    const OK = 'OK';

    private $user;
    private $failedAttemptService;

    public function __construct(User $user, $failedAttemptService)
    {
        $this->user = $user;
        $this->failedAttemptService = $failedAttemptService;
    }

    public function handle()
    {
        if ($this->user->web_ip()) {
            // Check for failed attempts.
            $failedAttempt = $this->failedAttemptService->checkForFailedAttempts($this->user->web_ip());

            // Remove failed attempt too.
            if ($failedAttempt) {
                $this->dispatchNow(new DeleteFailedAttempt($failedAttempt));
            }
        }

        // Update user
        $this->user->update(['status' => self::OK, 'blocked_by' => null, 'blocked_desc' => null, 'availDt' => Carbon::now()]);

        // Fire event to send mail
        return event(new AccountWasUnblocked($this->user));
    }
}
