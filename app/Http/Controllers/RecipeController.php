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
        $categorieTypes = CategorieType::with('categories')->get();

        if (!empty($selectedIngredients)) {
            $recipes = Recipe::where(function ($query) use ($selectedIngredients) {
                foreach ($selectedIngredients as $ingredient) {
                    $query->orWhere('ingredients', 'LIKE', '%' . $ingredient . '%');
                }
            })->get();
        }

        return view('recipes.index', compact('recipes', 'categorieTypes'));
    }


    public function show(Categorie $categorie, $id)  // Pass $id here
    {
        // Find the recipe by ID
        $recipe = Recipe::findOrFail($id);

        // Fetch the recipes related to the category
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $recipe = Recipe::find($id);
        $categorieTypes = CategorieType::all();
        // Check if the recipe exists
        if (!$recipe) {
            // Handle the case when the recipe is not found
            return redirect()->route('recipes.index')->with('error', 'Recipe not found');
        }

        return view('recipes.show', compact('recipes', 'categorie', 'recipe', 'categorieTypes'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        $categorieTypes = CategorieType::with('categories')->get();
        $ingredients = [];  
        return view('recipes.create', compact('categorieTypes', 'ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|array',
            'instructions.*' => 'required|string',
            'ingredients' => 'required|array', // Ingredients as an array
            'ingredients.*.name' => 'required|string', // Ingredient name is required and should be a string
            'ingredients.*.quantity' => 'required|numeric', // Quantity is required and should be a number
            'ingredients.*.unit' => 'required|string', // Ingredient unit
            'cook_time' => 'nullable|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cara_memasak_id' => 'required|exists:categories,id',
            'jenis_hidangan_id' => 'required|exists:categories,id',
            'kategori_khas_id' => 'required|exists:categories,id',
            'bahan_utama_id' => 'required|exists:categories,id',
            'tujuan_makanan_id' => 'required|exists:categories,id',
        ]);
        
        // Encode instructions and ingredients as JSON
        $instructions = json_encode($request->instructions);
        $ingredients = json_encode($request->ingredients);
    
        // Handle the image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName); // Save to public/images directory
        } else {
            return redirect()->back()->with('error', 'Image upload failed.');
        }
    
        // Create the recipe
        Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructions' => $instructions,
            'ingredients' => $ingredients,
            'cook_time' => $request->cook_time,
            'image_url' => '/images/' . $imageName, 
            'cara_memasak_id' => $request->cara_memasak_id,
            'jenis_hidangan_id' => $request->jenis_hidangan_id,
            'kategori_khas_id' => $request->kategori_khas_id,
            'bahan_utama_id' => $request->bahan_utama_id,
            'tujuan_makanan_id' => $request->tujuan_makanan_id,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully');
    }
    
    
   // Fungsi untuk menampilkan form edit resep
   public function edit($id)
   {
       // Fetch the recipe by ID
       $recipe = Recipe::findOrFail($id);
       $recipe->instructions = is_string($recipe->instructions) ? json_decode($recipe->instructions, true) : $recipe->instructions;
       $categorieTypes = CategorieType::with('categories')->get();

       if (is_string($recipe->ingredients)) {
        $recipe->ingredients = json_decode($recipe->ingredients, true);
    }
   
       return view('recipes.edit', compact('recipe', 'categorieTypes'));
   }
   
   public function update(Request $request, $id)
   {
       $request->validate([
           'title' => 'required|string|max:255',
           'description' => 'required|string',
           'instructions' => 'required|array',
           'instructions.*' => 'required|string',
           'ingredients' => 'required|array',
           'ingredients.*.name' => 'required|string',
           'ingredients.*.quantity' => 'required|integer',
           'ingredients.*.unit' => 'required|string',
           'cook_time' => 'required|integer',
           'cara_memasak_id' => 'required|exists:categories,id',
           'jenis_hidangan_id' => 'required|exists:categories,id',
           'kategori_khas_id' => 'required|exists:categories,id',
           'bahan_utama_id' => 'required|exists:categories,id',
           'tujuan_makanan_id' => 'required|exists:categories,id',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);
   
       // Retrieve the recipe to update
       $recipe = Recipe::findOrFail($id);
   
       // Update recipe data
       $recipe->title = $request->title;
       $recipe->description = $request->description;
       $recipe->cook_time = $request->cook_time;
       $recipe->cara_memasak_id = $request->cara_memasak_id;
       $recipe->jenis_hidangan_id = $request->jenis_hidangan_id;
       $recipe->kategori_khas_id = $request->kategori_khas_id;
       $recipe->bahan_utama_id = $request->bahan_utama_id;
       $recipe->tujuan_makanan_id = $request->tujuan_makanan_id;
   
       // Update or replace recipe image if provided
       if ($request->hasFile('image')) {
           $imagePath = $request->file('image')->store('recipes', 'public');
           $recipe->image = $imagePath;
       }
   
       // Update ingredients and instructions
       $recipe->ingredients = json_encode($request->ingredients);
       $recipe->instructions = json_encode($request->instructions);
   
       // Save the updated recipe
       $recipe->save();
   
       return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully');
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
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }


    // Menampilkan resep berdasarkan jenis hidangan
    public function showByType($type)
    {
        // Fetch the categorie by the provided type (assuming 'type' corresponds to categorie id)
        $categorie = Categorie::where('nama', $type)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    // Menampilkan resep berdasarkan kategori khas (makanan tradisional/internasional)
    public function showByCuisine($cuisine)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $cuisine)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    public function showByIngredient($ingredient)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $ingredient)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    // Menampilkan resep berdasarkan tujuan makanan
    public function showByPurpose($purpose)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $purpose)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    public function showByRecommendation($recommendation)
    {
        // Get the category based on the method name (assuming 'method' corresponds to a category name)
        $categorie = Categorie::where('nama', $recommendation)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
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
    public function showIngredients()
    {
        $ingredients = Ingredient::all();
        return view('Ingredients.index', compact('ingredients'));
    }

    public function saveRecipe($recipeId)
    {
        $user = Auth::user(); // Get the authenticated user
        $recipe = Recipe::findOrFail($recipeId); // Find the recipe by ID

        // Add the recipe to the user's favorites if not already saved
        if (!$user->favorites->contains($recipe)) {
            $user->favorites()->attach($recipe); // Attach the recipe to the user's favorites
        }

        // Redirect back with a success message
        return redirect()->route('recipes.show', $recipeId)->with('success', 'Resep telah disimpan ke favorit.');
    }

    public function save($id)
    {
        // Menyimpan resep ke dalam daftar favorit pengguna
        $recipe = Recipe::findOrFail($id);
        Auth::user()->favorites()->attach($recipe); // Anda bisa menggunakan pivot table 'favorites'

        // Mengarahkan ke halaman resep favorit
        return redirect()->route('favorite.recipes')->with('success', 'Resep berhasil disimpan.');
    }

    public function favoriteRecipes()
    {
        $user = auth()->user(); // Get the authenticated user
        $favorites = $user->favorites; // Get the user's favorite recipes
        $recipes = Auth::user()->favorites;
        
        return view('favorites.index', compact('user', 'favorites', 'recipes')); // Pass the $user to the view
    }
    
    public function removeFavorite(Recipe $recipe)
    {
        // Assuming the user is already authenticated and the recipe is already in favorites
        $user = auth()->user();
        
        // Detach the recipe from the user's favorites
        $user->favorites()->detach($recipe);

        // Redirect back to the favorites page with a success message
        return redirect()->route('profile.favorites')->with('success', 'Resep berhasil dihapus dari favorit');
    }

    public function saveFavorite(Request $request, $recipeId)
    {
        $user = auth()->user();
        $recipe = Recipe::findOrFail($recipeId);

        // Cek apakah resep sudah ada di daftar favorit
        if ($user->favorites()->where('recipe_id', $recipeId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Resep sudah ada di favorit Anda.'
            ]);
        }

        // Tambahkan resep ke favorit
        $user->favorites()->attach($recipeId);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil disimpan di favorit Anda.'
        ]);
    }



}
