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
            if ($request->is('perguruan-tinggi/*')) {
                return redirect()->route(route: 'perguruan-tinggi.login');
            }
            if ($request->is('dosen-pendamping/*')) {
                return redirect()->route('dosen-pendamping.login');
            }
            return redirect()->route('home');
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
        if ($request->is('perguruan-tinggi/*')) {
            return 'pimpinan';
        }
        if ($request->is('dosen-pendamping/*')) {
            return 'dospem';
        }
        return 'web';
    }
}
