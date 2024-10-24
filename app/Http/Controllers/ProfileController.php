<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Favorite;
use App\Models\User; 

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('recipe')->get(); // Ambil data favorit dan relasi resep

        return view('profile.show', compact('user', 'favorites'));
    }
}
