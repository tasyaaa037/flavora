<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan formulir login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan Anda memiliki view ini
    }

    // Mengolah login
    public function login(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Menggunakan Auth::attempt untuk autentikasi
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika login berhasil, redirect ke halaman yang diinginkan
            return redirect()->intended(route('home')); // Pastikan route 'home' sudah didefinisikan
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email')); // Mengingat email yang dimasukkan
    }

    // Mengolah logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login'); // Ganti dengan route login Anda
    }
}
