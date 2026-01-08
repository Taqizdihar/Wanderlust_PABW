<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller {

    public function showLoginForm() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->peran) {
                case 'administrator':
                    return redirect()->route('dashboard.admin');
                case 'pemilik':
                    return redirect()->route('dashboard.ptw');
                case 'wisatawan':
                    return redirect()->route('home');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Peran akun tidak valid.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}