<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if (! ($user->is_admin ?? false)) {
            return redirect('/')->with('error', 'Access restricted to administrators.');
        }

        return $next($request);
    }
}
