<?php

namespace App\Http\Controllers\Pengusul;

use App\Models\Pengusul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function create()
    {
        return view('pengusul.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = Pengusul::where('username', $credentials['username'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('pengusul')->login($user, $request->filled('remember'));
            $request->session()->regenerate();
            $request->session()->put('auth.guard', 'pengusul');
            return redirect()->intended(route('pengusul.dashboard'));
        }
        return back()->withErrors([
            'auth' => 'Periksa username dan password anda.'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('pengusul')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('pengusul.login');
    }
}
