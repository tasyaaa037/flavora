<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Menyimpan komentar baru untuk resep
    public function store(Request $request, $recipeId)
    {
        $request->validate(['content' => 'required|string']);

        $comment = new Comment($request->all());
        $comment->recipe_id = $recipeId;
        $comment->save();

        return redirect()->route('recipes.show', $recipeId)->with('success', 'Comment added successfully.');
    }
}
