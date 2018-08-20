<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        // Simple IP whitelist.
        if (app()->isDownForMaintenance() && ! in_array($request->ip(), config('orbit.whitelist'))) {
            $data = json_decode(file_get_contents(app()->storagePath().'/framework/down'), true);
            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }
}
