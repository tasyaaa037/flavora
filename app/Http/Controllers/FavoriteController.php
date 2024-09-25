<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // Menambahkan resep ke favorit
    public function store(Request $request, $recipeId)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $favorite = new Favorite();
        $favorite->user_id = $request->user_id;
        $favorite->recipe_id = $recipeId;
        $favorite->save();

        return redirect()->route('recipes.show', $recipeId)->with('success', 'Recipe added to favorites.');
    }

    // Menghapus resep dari favorit
    public function destroy($recipeId)
    {
        $favorite = Favorite::where('recipe_id', $recipeId)->where('user_id', auth()->id())->first();
        if ($favorite) {
            $favorite->delete();
        }
        return redirect()->route('recipes.show', $recipeId)->with('success', 'Recipe removed from favorites.');
    }
}
