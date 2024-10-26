<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Otentikasi extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Tentukan guard berdasarkan URL
            if ($request->is('operator/*')) {
                return route('operator.login');
            } else if ($request->is('pengusul/*')) {
                return route('pengusul.login');
            }

            // Default fallback
            return route('login');
        }
        return null;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        Log::info('Guards:', ['guards' => $guards]);
        Log::info('Current URL:', ['url' => $request->url()]);
        Log::info('Auth Status:', [
            'pengusul' => Auth::guard('pengusul')->check(),
            'operator' => Auth::guard('operator')->check()
        ]);
    
        if (empty($guards)) {
            $guards = [null];
        }
    
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Log::info('Authenticated with guard:', ['guard' => $guard]);
                return $next($request);
            }
        }
    
        Log::info('Redirecting to:', ['url' => $this->redirectTo($request)]);
        
        return $this->redirectTo($request)
            ? redirect()->guest($this->redirectTo($request))
            : $next($request);
    }
}

    // protected function redirectTo(Request $request): ?string
    // {
    //     if (! $request->expectsJson()) {
    //         $guardRoutes = [
    //             'operator' => 'operator.login',
    //             // 'admin' => 'admin.login',
    //         ];

    //         foreach ($guardRoutes as $guard => $route) {
    //             if (Auth::guard($guard)->check()) {
    //                 return route($route);
    //             }
    //         }

    //         if ($request->is('operator/*')) {
    //             return route('operator.login');
    //         } else if ($request->is('admin/*')) {
    //             return route('admin.login');
    //         }

    //         return route('login');
    //     }
    //     return null;
    // }
