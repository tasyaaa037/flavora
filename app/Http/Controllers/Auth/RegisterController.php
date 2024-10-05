<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Redirect users after registration
    protected $redirectTo = '/home'; // Atur ulang jika tidak digunakan

    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration request
    public function register(Request $request)
    {
        // Validasi data
        $this->validator($request->all())->validate();

        // Buat pengguna baru
        $user = $this->create($request->all());

        // Setelah berhasil membuat akun, arahkan ke halaman login
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    // Validator function
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Create a new user instance after a valid registration.
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
