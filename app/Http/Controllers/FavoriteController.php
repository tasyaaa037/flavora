<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\Favorite; // Import the Favorite model

class FavoriteController extends Controller
{
    // Menyimpan resep ke favorit
    public function store($id)
    {
        $user = Auth::user();

        // Check if the recipe is already in the user's favorites
        if ($user->favorites()->where('recipe_id', $id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Resep sudah ada di favorit']);
        }

        // Add the recipe to the user's favorites
        $favorite = new Favorite();
        $favorite->user_id = $user->id;
        $favorite->recipe_id = $id;
        $favorite->save();

        return response()->json(['success' => true, 'message' => 'Resep berhasil ditambahkan ke favorit']);
    }

    // Menampilkan daftar favorit pengguna
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('recipe')->get();

        return view('favorites.index', compact('favorites'));
    }
}
