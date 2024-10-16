<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite; // Model untuk resep favorit

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Mengambil user yang sedang login
        $favorites = $user->favorites; // Ambil data favorit user

        return view('favorites.index', compact('user', 'favorites')); // Kirim data user dan favorites ke view
    }

}
