<?php

namespace App\Http\Controllers\Operator;

use App\Models\OperatorPt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('operator.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = OperatorPt::where('username', $credentials['username'])->first();
        if (Auth::guard('operator')->attempt($credentials, $request->boolean('remember'))) {
            Auth::guard('operator')->login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            $request->session()->put('auth.guard', 'operator');
            return redirect()->intended(route('operator.dashboard'));
        }

        return back()
            ->withErrors([
                'auth' => 'Periksa username dan password anda.'
            ])
            ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('operator')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/operator/login');
    }
}
