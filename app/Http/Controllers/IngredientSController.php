<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngredientSController extends Controller
{
    public function index() {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }
    
    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('ingredients.show', compact('ingredient'));
    }
    


}
