<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CustomerMiddleware 
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect('/');
        }
        return $next($request);
    }
}
