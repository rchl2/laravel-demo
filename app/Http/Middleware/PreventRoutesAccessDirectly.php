<?php

namespace App\Http\Middleware;

use Closure;

class PreventRoutesAccessDirectly
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (! $request->ajax()) {
            return response()->json(['error' => 'Not authorized'], 403);
        }

        return $next($request);
    }
}
