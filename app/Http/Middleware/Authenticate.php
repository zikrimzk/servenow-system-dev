<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('admin/*') && !Auth::guard('admin')->check()) {
            return route('admin-login'); // Redirect to admin login if not authenticated as admin
        }

        if ($request->is('tasker/*') && !Auth::guard('tasker')->check()) {
            return route('tasker-login'); // Redirect to tasker login if not authenticated as tasker
        }
    }
}
