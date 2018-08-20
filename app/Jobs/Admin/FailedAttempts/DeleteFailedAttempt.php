<?php

namespace App\Jobs\Admin\FailedAttempts;

use App\Models\FailedAttempts;

final class DeleteFailedAttempt
{
    private $failedAttempt;

    public function __construct(FailedAttempts $failedAttempt)
    {
        $this->failedAttempt = $failedAttempt;
    }

    public function handle()
    {
        return $this->failedAttempt->delete();
    }
}
