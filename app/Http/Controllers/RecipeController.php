<?php
namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Subcategory; // Import model Subcategory
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        // Menampilkan semua resep dengan relasi yang diperlukan
        $recipes = Recipe::with(['user', 'ingredients', 'steps', 'comments', 'categories', 'subcategory', 'purpose'])->get();
        return view('recipes.index', compact('recipes'));
    }


    // Menampilkan detail resep tertentu
    public function show($id)
    {
        // Menampilkan detail resep dengan kategori dan subkategori
        $recipe = Recipe::with(['category', 'subcategory', 'comments'])->findOrFail($id);
        return view('recipes.show', compact('recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        // Mengambil semua kategori dan subkategori
        $categories = Category::with('subcategories')->get();
        return view('recipes.create', compact('categories'));
    }

    // Menyimpan resep baru ke database
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Membuat resep baru
        $recipe = Recipe::create($request->all());

        // Menetapkan kategori dan subkategori ke resep
        $recipe->categories()->sync($request->input('category_id'));
        $recipe->subcategory()->associate($request->input('subcategory_id'));
        
        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully.');
    }


    // Menampilkan formulir untuk mengedit resep
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);
        // Mengambil semua kategori dan subkategori
        $categories = Category::with('subcategories')->get();
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    // Memperbarui resep di database
    public function update(Request $request, $id)
    {
        // Validasi data yang masuk
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Memperbarui resep
        $recipe = Recipe::findOrFail($id);
        $recipe->update($request->all());

        // Memperbarui kategori dan subkategori
        $recipe->categories()->sync($request->input('category_id'));
        $recipe->subcategory()->associate($request->input('subcategory_id'));

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }


    // Menghapus resep dari database
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully.');
    }

    public function showByMethod($method)
    {
        $recipes = Recipe::where('cooking_method', $method)->get();
        return view('recipes.index', compact('recipes'));
    }

    public function byType($type)
    {
        // Logika untuk mengambil dan menampilkan resep berdasarkan tipe
        $recipes = Recipe::where('type', $type)->get();
        return view('recipes.index', compact('recipes'));
    }

    public function byCuisine($cuisine)
    {
        // Example logic to get recipes by cuisine
        $recipes = Recipe::where('cuisine', $cuisine)->get();
        return view('recipes.index', compact('recipes'));
    }

    public function byIngredient($ingredient)
    {
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', $ingredient);
        })->get();

        return view('recipes.index', compact('recipes'));
    }

    public function byPurpose($purpose)
    {
        // Ambil resep berdasarkan tujuan makanan
        $recipes = Recipe::whereHas('purpose', function($query) use ($purpose) {
            $query->where('name', $purpose);
        })->get();

        return view('recipes.index', compact('recipes'));
    }


}
