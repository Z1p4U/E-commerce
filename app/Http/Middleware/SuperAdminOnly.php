<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(auth('admin')->user()->hasRole('super-admin'));
        if (auth('admin')->check() && auth('admin')->user()->hasRole('super-admin')) {
            return $next($request);
        }

        abort(401, 'Unauthorized action.');
        // return $next($request);
    }
}
