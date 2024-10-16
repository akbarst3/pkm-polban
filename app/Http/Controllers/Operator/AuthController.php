<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        // if (Auth::guard('operator')->check()) {
        //     return redirect()->route('operator.dashboard');
        // }
        return view('operator.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('operator')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
<<<<<<< HEAD
<<<<<<< HEAD
            return redirect()->intended(route('operator.dashboard'));
        }

        return back()
            ->withErrors([
                'auth' => 'Periksa username dan password anda.'
            ])
            ->onlyInput('username');
=======
            return redirect()->intended('/operator/dashboard');
        }
        return back()->withErrors([
            'username' => 'username salah.'
        ])->onlyInput('username');
>>>>>>> 73a62b1 (add: login operator)
=======
            return redirect()->intended(route('operator.dashboard'));
        }

        return back()
            ->withErrors([
                'auth' => 'Periksa username dan password anda.'
            ])
            ->onlyInput('username');
>>>>>>> c7e1417 (feat: error and session handling)
    }


    public function logout(Request $request)
    {
        Auth::guard('operator')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/operator/login');
    }
}
