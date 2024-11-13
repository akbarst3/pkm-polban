<?php

namespace App\Http\Controllers\Pimpinan;

use App\Models\PerguruanTinggi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function create()
    {
        return view('pimpinan.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = PerguruanTinggi::where('username', $credentials['username'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('pimpinan')->login($user, $request->filled('remember'));
            $request->session()->regenerate();
            $request->session()->put('auth.guard', 'pimpinan');
            return redirect()->intended(route('perguruan-tinggi.dashboard'));
        }
        return back()->withErrors([
            'auth' => 'Periksa username dan password anda.'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('pimpinan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('perguruan-tinggi.login');
    }
}
