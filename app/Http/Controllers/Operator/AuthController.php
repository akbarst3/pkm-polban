<?php

namespace App\Http\Controllers\Operator;

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
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::guard('operator')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/operator/dashboard');
        }
        return back()->withErrors([
            'username' => 'username salah.'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('operator')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/operator/login');
    }
}
