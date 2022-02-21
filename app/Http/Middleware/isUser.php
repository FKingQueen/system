<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()) 
        {
            abort(403, 'Not found');
        } elseif (auth()->user()->role_id == 2) 
        {
            return $next($request);
        } else 
        {
            abort(403, 'Not found');
        }
    }
}
