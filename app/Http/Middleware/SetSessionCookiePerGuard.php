<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class SetSessionCookiePerGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check the guard and set the appropriate session cookie
        if (Auth::guard('tasker')->check()) {
            Config::set('session.cookie', env('TASKER_SESSION_COOKIE', 'tasker_session_cookie'));
        } elseif (Auth::guard('admin')->check()) {
            Config::set('session.cookie', env('ADMIN_SESSION_COOKIE', 'admin_session_cookie'));
        }

        return $next($request);
    }
}
