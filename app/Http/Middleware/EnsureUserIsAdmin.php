<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // If the user is not logged in, let auth middleware handle redirect.
        if (! $user) {
            return $next($request);
        }

        if (! ($user->is_admin ?? false)) {
            // Redirect authenticated non-admin users back to application home.
            // Auth middleware should handle unauthenticated users earlier on the route.
            return redirect('/')->with('error', 'Access restricted to administrators.');
        }

        return $next($request);
    }
}
