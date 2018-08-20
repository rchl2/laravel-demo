<?php

namespace App\Services;

use App\Models\FailedAttempts;
use App\Queries\FailedAttemptsQueries;

class FailedAttemptService
{
    /**
     * Check for failed attempts with given IP address.
     */
    private function checkForFailedAttempts(string $ip): ?FailedAttempts
    {
        return FailedAttemptsQueries::findByIpAddress($ip);
    }
}
