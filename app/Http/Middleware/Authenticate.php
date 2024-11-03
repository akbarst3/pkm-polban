<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $currentGuard = $this->determineGuard($request);
            if (!Auth::guard($currentGuard)->check()) {
                throw new \Exception('Unauthenticated');
            }
            $user = Auth::guard($currentGuard)->user();
            if ($currentGuard === 'operator' && empty($user->kode_pt)) {
                Auth::guard($currentGuard)->logout();
                throw new \Exception('Invalid operator data');
            }
            return $next($request);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            if ($request->is('operator/*')) {
                return redirect()->route('operator.login');
            }
            if ($request->is('pengusul/*')) {
                return redirect()->route('pengusul.login');
            }

            return redirect()->route('login');
        }
    }

    private function determineGuard(Request $request): string
    {
        if ($request->is('operator/*')) {
            return 'operator';
        }
        if ($request->is('pengusul/*')) {
            return 'pengusul';
        }
        return 'web';
    }
}
