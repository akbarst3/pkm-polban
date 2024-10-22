<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class OpAuth extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            $guardRoutes = [
                'operator' => 'operator.login',
                // 'admin' => 'admin.login',
            ];
    
            foreach ($guardRoutes as $guard => $route) {
                if (Auth::guard($guard)->check()) {
                    return route($route);
                }
            }
    
            if ($request->is('operator/*')) {
                return route('operator.login');
            } else if ($request->is('admin/*')) {
                return route('admin.login');
            }
    
            return route('login');
        }
        return null;
    }
}