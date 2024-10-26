<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionTimeout    
{
    protected $guards = ['operator', 'pengusul'];
    protected $timeout = 1200;

    public function handle(Request $request, Closure $next)
    {
        foreach ($this->guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $lastActivity = $request->session()->get($guard . '_last_activity');
                $now = Carbon::now();
                $successMessage = session('success');

                if ($lastActivity) {
                    $lastActivity = Carbon::parse($lastActivity);
                    $timeDifference = $now->getTimestamp() - $lastActivity->getTimestamp();

                    if ($timeDifference > $this->timeout) {
                        Auth::guard($guard)->logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();

                        return redirect()->route($guard . '.login')
                            ->with('timeout_message', 'Sesi Anda telah berakhir. Silakan login kembali.');
                    }
                }

                $request->session()->put($guard . '_last_activity', $now->toDateTimeString());

                if ($successMessage) {
                    session()->now('success', $successMessage);
                }

                break;
            }
        }

        return $next($request);
    }
}


// class SessionTimeout
// {
//     public function handle(Request $request, Closure $next)
//     {
//         if (Auth::guard('operator')->check()) {
//             $lastActivity = $request->session()->get('last_activity');
//             $now = Carbon::now();
//             $successMessage = session('success');
//             if ($lastActivity) {
//                 $lastActivity = Carbon::parse($lastActivity);
//                 $timeDifference = $now->getTimestamp() - $lastActivity->getTimestamp();

//                 if ($timeDifference > 1200) {
//                     Auth::guard('operator')->logout();
//                     $request->session()->invalidate();
//                     $request->session()->regenerateToken();
//                     return redirect()->route('operator.login')
//                         ->with('timeout_message', 'Sesi Anda telah berakhir. Silakan login kembali.');
//                 }
//             }
//             $request->session()->put('last_activity', $now->toDateTimeString());
//             if ($successMessage) {
//                 session()->now('success', $successMessage);
//             }
//         }
//         return $next($request);
//     }
// }
