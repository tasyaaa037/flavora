<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngredientSController extends Controller
{
    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $recipes = $ingredient->recipes; // Assuming Ingredient has a 'recipes' relationship

        return view('ingredients.show', compact('ingredient', 'recipes'));
    }

}
