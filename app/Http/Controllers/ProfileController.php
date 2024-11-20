<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Favorite;
use App\Models\User; 
use App\Models\Comment;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('recipe')->get(); // Ambil data favorit dan relasi resep
        $comments = Comment::where('user_id', $user->id)->with('recipe')->latest()->get(); 
        return view('profile.show', compact('user', 'favorites', 'comments'));
    }

    public function removeFavorite($recipeId)
    {
        // Assuming that you have a relationship between the User and Recipe models,
        // and the user can have many favorite recipes.
        $user = auth()->user(); // Get the authenticated user
        $recipe = $user->favorites()->findOrFail($recipeId); // Find the recipe

        // Detach the recipe from the user's favorites (many-to-many relationship)
        $user->favorites()->detach($recipeId);

        // Redirect back with a success message
        return redirect()->route('profile.favorites')->with('success', 'Recipe removed from favorites');
    }

    public function favorites()
    {
        // Fetch user's favorite items (customize as per your app's requirements)
        $favorites = auth()->user()->favorites; // Assuming a relationship or data exists
        $user = auth()->user(); 
        return view('favorites.index', compact('favorites', 'user')); // Adjust view file as needed
    }

    public function removeComment($commentId)
    {
        
        $comment = Comment::where('id', $commentId)->where('user_id', auth()->id())->first();

        if ($comment) {
            $comment->delete();
            return redirect()->route('profile.show')->with('success', 'Komentar telah dihapus');
        }

        return redirect()->route('profile.show')->with('error', 'Komentar tidak ditemukan');
    }
}
