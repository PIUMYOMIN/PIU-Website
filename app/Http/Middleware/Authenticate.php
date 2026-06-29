<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * This app is API-only (see RouteServiceProvider — there is no
     * routes/web.php and no "/login" page exists). Always return null so
     * Laravel falls back to its default 401 JSON response instead of
     * attempting a browser redirect to a route that doesn't exist.
     */
    protected function redirectTo(Request $request): ?string
    {
        return null;
    }
}