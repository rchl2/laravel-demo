<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isAdmin()) 
        {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
