<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika sudah login, lempar ke dashboard
        if (session('is_admin_logged_in')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $envUsername = env('ADMIN_USERNAME');
        $envPassword = env('ADMIN_PASSWORD');

        if ($request->username === $envUsername && $request->password === $envPassword) {
            session(['is_admin_logged_in' => true]);
            return redirect()->route('dashboard')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['error' => 'Username atau password salah!'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin_logged_in');
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
