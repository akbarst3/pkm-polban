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
        Log::info('Login attempt started', [
            'username' => $request->username
        ]);

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = Pengusul::where('username', $credentials['username'])->first();

        Log::info('User query result', [
            'found' => !is_null($user),
            'username' => $user?->username
        ]);

        if ($user && Hash::check($credentials['password'], $user->password_hashed)) {
            Log::info('Password match successful');

            if ($request->hasSession()) {
                $request->session()->flush();
            }

            Auth::guard('pengusul')->login($user, $request->filled('remember'));

            Log::info('Login status', [
                'is_logged_in' => Auth::guard('pengusul')->check(),
                'authenticated_username' => Auth::guard('pengusul')->user()?->username
            ]);

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
