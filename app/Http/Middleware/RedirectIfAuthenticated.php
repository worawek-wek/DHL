<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(auth()->user()->isAdmin()) {
    
                return redirect('shipping');
    
            } else if(auth()->user()->isShipping()) {
    
                return redirect('shipping');
    
            } else if(auth()->user()->isFinance()) {
    
                return redirect('finance');
    
            } else if(auth()->user()->isBilling()) {
    
                return redirect('biliing');
    
            }
        }

        return $next($request);
    }
}
