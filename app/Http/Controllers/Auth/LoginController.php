<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    // tampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    // Proces login

    public function login(Request $request)
    {
        // langkah 1, validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'min:6',
        ]);

        // langkah 2, cek apakah user aktif

        $user = User::where('email', $request->email)->first();

        if ($user && ! $user->is_active) {
            return back()->withErrors([
                'email' => 'Your Account Is Deactivated, Contact The Super Admin Immediately.',
            ])->withInput();
        }

        // langkah 3, coba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // cegah session fixation attack

            Alert::success('Success', 'Login Successful');

            if (Auth::user()->hasRole('tamu')) {
                return redirect()->intended(route('home'));
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        // langkah 4, kalau gagal

        return back()->withErrors([
            'email' => 'Incorrect Email or Password!',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Success', 'Logout Successful');

        return redirect()->route('login');
    }
}
