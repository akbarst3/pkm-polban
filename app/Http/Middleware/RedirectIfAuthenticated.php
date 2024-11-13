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
                if ($guard === 'pengusul') {
                    return redirect()->route('pengusul.dashboard');
                } else if ($guard === 'operator') {
                    return redirect()->route('operator.dashboard');
                } else if ($guard === 'pimpinan') {
                    return redirect()->route('perguruan-tinggi.dashboard');
                } else if ($guard === 'dospem') {
                    return redirect()->route('dosen-pendamping.dashboard');
                }
                return redirect('/home');
            }
        }
        return $next($request);
    }
}
