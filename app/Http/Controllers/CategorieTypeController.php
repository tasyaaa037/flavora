<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CategorieTypeController extends Controller
{

    public function create()
    {
        $categorieTypes = CategorieType::with('categories')->get();
        return view('recipes.create', compact('categorieTypes'));
    }

    public function index() {
        $categories = Category::all(); // Assuming you have a Category model
        return view('subcategories.index', compact('categories'));
    }
    
    public function show($id) {
        $category = Category::find($id); // Assuming you have relationships set up
        $recipes = $category->recipes;
        return view('subcategories.show', compact('category', 'recipes'));
    }
    
}
