<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

       if (Auth::attempt($credentials)) {

    $request->session()->regenerate();

    $user = Auth::user();

    // Cek apakah akun aktif
    if ($user->status != 'aktif') {

        Auth::logout();

        return back()->withErrors([
            'email' => 'Akun Anda dinonaktifkan.'
        ]);
    }

    // Redirect berdasarkan role
    if ($user->role == 'admin') {
        return redirect('/dashboard/admin');
    }

    if ($user->role == 'kasir') {
        return redirect('/dashboard/kasir');
    }

    return redirect('/dashboard/user');
    }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->onlyInput('email');
    }

    // ===========================
    // REGISTER
    // ===========================

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'no_hp' => 'required|string|max:20',
        'password' => 'required|confirmed|min:8',
    ]);

    User::create([
        'nama' => $validated['nama'],
        'email' => $validated['email'],
        'no_hp' => $validated['no_hp'],
        'password' => $validated['password'],
        'role' => 'user',
        'status' => 'aktif',
    ]);

    return redirect('/login')
        ->with('success', 'Registrasi berhasil! Silakan login.');
}
}