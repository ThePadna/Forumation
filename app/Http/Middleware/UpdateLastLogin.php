<?php

namespace App\Http\Middleware;

use Closure;

class UpdateLastLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()) $request->user()->updateActivity();
        return $next($request);
    }
}
