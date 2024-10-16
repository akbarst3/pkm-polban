<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('operator')->check()) {
            $lastActivity = $request->session()->get('last_activity');
            $now = Carbon::now();

            if ($lastActivity) {
                $lastActivity = Carbon::parse($lastActivity);

                $timeDifference = $now->getTimestamp() - $lastActivity->getTimestamp();

                if ($timeDifference > 1200) {
                    Auth::guard('operator')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('operator.login')->with('timeout_message', 'Sesi Anda telah berakhir. Silakan login kembali.');
                }
            }
            $request->session()->put('last_activity', $now->toDateTimeString());
            $request->session()->save();
        }
        return $next($request);
    }
}
