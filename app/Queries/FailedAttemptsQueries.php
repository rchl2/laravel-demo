<?php

namespace App\Queries;

use App\Models\FailedAttempts;

final class FailedAttemptsQueries
{
    /**
     * Find failed attempts by IP address.
     */
    public static function findByIpAddress(string $ip): ?FailedAttempts
    {
        return FailedAttempts::where('ip', $ip)
            ->first();
    }
}
