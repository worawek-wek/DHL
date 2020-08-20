<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Middleware\RedirectIfAuthenticated;

class Billing
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
        if(!Auth::user()->isBilling()) {
            return $next($request);
        } else {
            return redirect('login');
        }
    }
}