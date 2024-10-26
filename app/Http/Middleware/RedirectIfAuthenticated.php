<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Log::info('RedirectIfAuthenticated: User authenticated with guard', [
                    'guard' => $guard,
                    'isAuthenticated' => Auth::guard($guard)->check(),
                    'user' => Auth::guard($guard)->user()
                ]);

                // Ubah logika redirect
                if ($guard === 'pengusul') {
                    return redirect()->route('pengusul.dashboard');
                } else if ($guard === 'operator') {
                    return redirect()->route('operator.dashboard');
                }

                return redirect('/home');
            }
        }
        return $next($request);
    }
}
