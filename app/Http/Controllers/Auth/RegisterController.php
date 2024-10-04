<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan Anda memiliki view ini
    }

    // Mengolah pendaftaran (tambahkan metode ini jika belum ada)
    public function register(Request $request)
    {
        // Validasi data pendaftaran
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Logika untuk membuat pengguna baru
        // User::create([...]);

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil!'); // Ganti 'home' dengan route yang sesuai
    }
}
