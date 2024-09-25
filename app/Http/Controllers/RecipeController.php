<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // Menampilkan daftar semua resep
    public function index()
    {
        $recipes = Recipe::with('category')->get();
        return view('recipes.index', compact('recipes'));
    }

    // Menampilkan detail resep tertentu
    public function show($id)
    {
        $recipe = Recipe::with('category', 'comments')->findOrFail($id);
        return view('recipes.show', compact('recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    // Menyimpan resep baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Recipe::create($request->all());
        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully.');
    }

    // Menampilkan formulir untuk mengedit resep
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);
        $categories = Category::all();
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    // Memperbarui resep di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->update($request->all());
        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }

    // Menghapus resep dari database
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully.');
    }
}
