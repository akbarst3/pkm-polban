<?php

namespace App\Http\Controllers\Dospem;

use Illuminate\Http\Request;
use App\Models\DosenPendamping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function create()
    {
        return view('dospem.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = DosenPendamping::where('username', $credentials['username'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('dospem')->login($user, $request->filled('remember'));
            $request->session()->regenerate();
            $request->session()->put('auth.guard', 'dospem');
            return redirect()->intended(route('dosen-pendamping.dashboard'));
        }
        return back()->withErrors([
            'auth' => 'Periksa username dan password anda.'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('dospem')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('dosen-pendamping.login');
    }
}
