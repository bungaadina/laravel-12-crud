<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses Logika Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Pengalihan berdasarkan role
            if ($user->role === 'admin' || $user->role === 'staff') {
                return redirect()->intended(route('products.index'));
            }

            return redirect()->intended('/');
        }

        return back()->with('failed', 'Email atau password salah!');
    }

    // Menampilkan Form Registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses Registrasi User Baru
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role'     => 'required|in:admin,staff,customer',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}