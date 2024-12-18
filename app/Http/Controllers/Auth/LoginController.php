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
        $redirect = request()->input('redirect');
        if ($redirect) {
            session(['url.intended' => $redirect]); // Simpan URL tujuan di session
        }

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
            return redirect()->intended(); // Mengarahkan pengguna ke URL yang disimpan
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email')); // Mengingat email yang dimasukkan
    }

    // Mengolah logout
    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Menghapus semua sesi pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman home atau login
        return redirect()->route('home'); // Ganti dengan route home atau login Anda
    }

    // Menyimpan URL redirect
    public function setRedirectUrl(Request $request)
    {
        $request->validate([
            'redirectUrl' => 'required|url',
        ]);

        session(['redirectAfterLogin' => $request->redirectUrl]);
        return response()->json(['success' => true]);
    }

    // Mengarahkan pengguna setelah login
    protected function authenticated(Request $request, $user)
    {
        // Ambil URL dari session
        $redirectUrl = session('redirectAfterLogin', '/home'); // Default ke '/home' jika tidak ada session

        // Hapus URL dari session setelah digunakan
        session()->forget('redirectAfterLogin');

        // Redirect ke URL tersebut
        return redirect()->to($redirectUrl);
    }

}
