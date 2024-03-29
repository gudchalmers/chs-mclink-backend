<?php

namespace App\Http\Middleware;

use Closure;

class TokenMiddleware
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
        if (!hash_equals($request->input('t', ''), env('TOKEN'))) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
