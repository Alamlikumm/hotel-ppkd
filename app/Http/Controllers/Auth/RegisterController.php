<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    // Proses registrasi guest
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cari atau buat role tamu secara otomatis
        $role = Role::firstOrCreate(
            ['slug' => 'tamu'],
            ['name' => 'Tamu']
        );

        // Buat user tamu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // hashed automatically via cast in User model
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        Alert::success('Success', 'Account Created Successfully. Welcome!');

        return redirect()->intended(route('home'));
    }
}
