<?php

namespace App\Http\Controllers;

use App\Models\Category; // Pastikan Anda mengimpor model Subcategory
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
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
