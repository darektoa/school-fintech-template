<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;

class IsSellerStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role = auth()->user()->role_id;

        if($role === 2 || $role === 4) {
            return $next($request);
        }

        abort('403');return $next($request);
    }
}
