<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Categorie;
use App\Models\CategorieType;
use App\Models\Ingredient;

class RecipeController extends Controller
{
    // Menampilkan daftar semua resep
    public function index(Request $request)
    {
        $recipes = Recipe::with(['categories', 'purpose'])->get();
        
        $selectedIngredients = $request->input('ingredients', []);
        
        if (!empty($selectedIngredients)) {
            $recipes = Recipe::where(function ($query) use ($selectedIngredients) {
                foreach ($selectedIngredients as $ingredient) {
                    $query->orWhere('ingredients', 'LIKE', '%' . $ingredient . '%');
                }
            })->get();
        }

        return view('recipes.index', compact('recipes'));
    }


    public function show(Categorie $categorie, $id)  // Pass $id here
    {
        // Find the recipe by ID
        $recipe = Recipe::findOrFail($id);

        // Fetch the recipes related to the category
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Check if the recipe exists
        if (!$recipe) {
            // Handle the case when the recipe is not found
            return redirect()->route('recipes.index')->with('error', 'Recipe not found');
        }

        return view('recipes.show', compact('recipes', 'categorie', 'recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        // Mengambil semua kategori beserta jenis kategorinya
        $categories = Categorie::with('categorieTypes')->get();
        $recipe = Recipe::all();
        $ingredients = Ingredient::all();
        $cookingMethods = Categorie::where('categorie_type_id', 1)->get();
        $dishTypes = Categorie::where('categorie_type_id', 2)->get();
        $specialties = Categorie::where('categorie_type_id', 3)->get();
        $mainIngredients = Categorie::where('categorie_type_id', 4)->get();
        $purposes = Categorie::where('categorie_type_id', 5)->get();
        
        return view('recipes.create', compact('recipe', 'ingredients', 'cookingMethods', 'dishTypes', 'specialties', 'mainIngredients', 'purposes'));
    }

    // Menambahkan resep baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'cook_time' => 'required|numeric',
            'image' => 'required|image|max:2048', // jika ada gambar
            'ingredients' => 'required|string', // bahan
        ]);

        // Menyimpan data ke database
        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->instructions = $request->instructions;
        $recipe->cook_time = $request->time;
        $recipe->ingredients = $request->ingredients; // simpan bahan

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $recipe->image = $imagePath;
        }

        $recipe->save();

        // Redirect ke halaman index setelah berhasil
        return redirect()->route('recipes.index')->with('success', 'Resep berhasil ditambahkan!');
    }


    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
            'prep_time' => 'required|integer',
            'price' => 'required|numeric',
            'servings' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $recipe->image = $imagePath;
        }

        $recipe->update($request->all());

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->route('recipes.index');
    }

    // Menampilkan resep berdasarkan kategori
    // Menampilkan daftar kategori resep
    public function showCategories()
    {
        // Mengambil semua CategorieType beserta Categories-nya
        $categorieTypes = CategorieType::with('categories')->get();

        return view('kategori.index', compact('categorieTypes')); // Mengubah 'categories' ke 'kategori.index'
    }

    // Menampilkan resep berdasarkan kategori tertentu
    public function showByCategorie($categorieId)
    {
        // Dapatkan kategori berdasarkan ID
        $categorie = Categorie::with('recipes')->findOrFail($categorieId);

        // Ambil semua resep dalam kategori tersebut
        $recipes = $categorie->recipes;

        // Kirim data kategori dan resep ke tampilan
        return view('kategori.show', compact('recipes', 'categorie')); // Mengubah 'recipes.index' ke 'kategori.show'
    }


    // Menampilkan resep berdasarkan metode memasak
    public function showByMethod($method)
    {
        // Get the category based on the method name (assuming 'method' corresponds to a category name)
        $categorie = Categorie::where('nama', $method)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }


    // Menampilkan resep berdasarkan jenis hidangan
    public function showByType($type)
    {
        // Fetch the categorie by the provided type (assuming 'type' corresponds to categorie id)
        $categorie = Categorie::where('nama', $type)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }

    // Menampilkan resep berdasarkan kategori khas (makanan tradisional/internasional)
    public function showByCuisine($cuisine)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $cuisine)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }

    public function showByIngredient($ingredient)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $ingredient)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }

    // Menampilkan resep berdasarkan tujuan makanan
    public function showByPurpose($purpose)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $purpose)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }


    // Menampilkan resep berdasarkan kategori umum
    public function byCategorie(Categorie $categorie)
    {
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        return view('recipes.index', compact('recipes'));
    }

    // Menampilkan resep berdasarkan kategori yang lebih spesifik
    private function showRecipesByCategorie($categorieId)
    {
        $categorie = Categorie::findOrFail($categorieId);
        $recipes = Recipe::where('categorie_id', $categorieId)->get(); 
        return view('recipes.index', compact('categorie', 'recipes'));
    }


    // Menampilkan resep favorit
    public function favorite()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $favorites = $user->favorites;
        return view('favorites.index', compact('user', 'favorites'));
    }

    // Menambahkan resep ke favorit
    public function addToFavorites($id)
    {
        $user = Auth::user();
        $recipe = Recipe::find($id);

        if ($recipe) {
            if (!$user->favorites()->where('recipe_id', $recipe->id)->exists()) {
                $user->favorites()->attach($recipe->id);
                return response()->json(['success' => true, 'message' => 'Resep berhasil ditambahkan ke favorit.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Resep sudah ada di daftar favorit.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Resep tidak ditemukan.']);
    }

    // Menampilkan halaman favorit
    public function showFavorites()
    {
        $user = Auth::user();
        $favorites = $user->favorites;
        return view('favorites.index', compact('favorites'));
    }

    // Menampilkan resep berdasarkan bahan yang tidak memiliki bahan tertentu
    public function showIngredients(Request $request)
    {
        $recipes = Recipe::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('ingredients')
                ->join('ingredient_recipe', 'ingredients.id', '=', 'ingredient_recipe.ingredient_id')
                ->whereRaw('recipes.id = ingredient_recipe.recipe_id');
        })->paginate(15);

        $total = $recipes->total();
        $ingredientName = $request->input('ingredient');
        $ingredients = Ingredient::all();

        return view('bahan.index', compact('recipes', 'total', 'ingredientName', 'ingredients'));
    }
}
