<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Purpose;
use App\Models\Ingredient;
use App\Models\Step;



class RecipeController extends Controller
{
    // Menampilkan daftar semua resep
    public function index()
    {
        $recipes = Recipe::with(['categories', 'subcategory', 'purpose'])->get();
        $selectedIngredients = $request->input('ingredients', []);
        $recipes = Recipe::where(function($query) use ($selectedIngredients) {
            foreach ($selectedIngredients as $ingredient) {
                $query->orWhere('ingredients', 'LIKE', '%' . $ingredient . '%');
            }
        })->get();

        return view('recipes.index', compact('recipes'));
    }

    // Menampilkan detail resep
    public function show($id)
    {
        $recipe = Recipe::with(['ingredients', 'steps', 'comments.user', 'categories', 'subcategory', 'purpose'])->findOrFail($id);
        return view('recipes.show', compact('recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $purposes = Purpose::all();
        return view('recipes.create', compact('categories', 'subcategories', 'purposes'));
    }

    // Menyimpan resep baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'purpose_id' => 'nullable|exists:purposes,id',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->servings = $request->servings;
        $recipe->description = $request->description;
        $recipe->category_id = $request->category_id;
        $recipe->subcategory_id = $request->subcategory_id;
        $recipe->purpose_id = $request->purpose_id;

        // Mengelola upload gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images');
            $recipe->image = $path;
        }

        $recipe->save();

        // Menyimpan ingredients dan steps
        foreach ($request->ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->name = $ingredientName;
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
        }

        foreach ($request->steps as $stepDescription) {
            $step = new Step();
            $step->description = $stepDescription;
            $step->recipe_id = $recipe->id;
            $step->save();
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully.');
    }

    // Menampilkan formulir untuk mengedit resep
    public function edit($id)
    {
        $recipe = Recipe::with('ingredients', 'steps')->findOrFail($id);
        $categories = Category::all();
        $recipe->subcategory_id = $request->subcategory_id;
        $recipe->purpose_id = $request->purpose_id;
    }

    // Memperbarui resep di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'purpose_id' => 'nullable|exists:purposes,id',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->title = $request->title;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->servings = $request->servings;
        $recipe->description = $request->description;
        $recipe->category_id = $request->category_id;
        $recipe->subcategory_id = $request->subcategory_id;
        $recipe->purpose_id = $request->purpose_id;

        // Mengelola upload gambar
        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::delete($recipe->image);
            }
            $path = $request->file('image')->store('images');
            $recipe->image = $path;
        }

        $recipe->save();

        // Memperbarui ingredients dan steps
        $recipe->ingredients()->delete();
        foreach ($request->ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->name = $ingredientName;
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
        }

        $recipe->steps()->delete();
        foreach ($request->steps as $stepDescription) {
            $step = new Step();
            $step->description = $stepDescription;
            $step->recipe_id = $recipe->id;
            $step->save();
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }

    // Menghapus resep dari database
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        if ($recipe->image) {
            Storage::delete($recipe->image); // Hapus gambar jika ada
        }
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully.');
    }

    // Menampilkan resep berdasarkan kategori
    public function category($category)
    {
        $recipes = Recipe::where('category_id', $category)->get();
        return view('recipes.index', compact('recipes'));
    }

     // Menampilkan resep berdasarkan subkategori
    public function subcategory($subcategory)
    {
         $recipes = Recipe::where('subcategory_id', $subcategory)->get();
         return view('recipes.index', compact('recipes'));
    }
    
    public function showByMethod($method)
    {
        $recipes = Recipe::where('cook_method', $method)->get();

        return view('recipes.index', compact('recipes'));
    }
     // Menampilkan resep berdasarkan tujuan
     public function byPurpose($purpose)
     {
         $recipes = Recipe::where('purpose_id', $purpose)->get();
         return view('recipes.index', compact('recipes'));
     }

       // Menampilkan resep berdasarkan bahan

       public function byType($type)
    {
        // Ambil data resep berdasarkan tipe yang diberikan
        $recipes = Recipe::where('type', '=', $type)->get();
        
        // Tampilkan view dengan data resep yang sesuai
        return view('recipes.index', ['recipes' => $recipes]);
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

    // Menampilkan resep berdasarkan rekomendasi
    // Menampilkan resep berdasarkan rekomendasi
    public function byRecommendation($type)
    {
        switch ($type) {
            case 'Resep Populer':
                $recipes = Recipe::orderBy('views', 'desc')->take(10)->get();
                break;
            case 'Resep Favorit':
                $recipes = Recipe::orderBy('favorites', 'desc')->take(10)->get();
                break;
            case 'Resep Terbaru':
                $recipes = Recipe::orderBy('created_at', 'desc')->take(10)->get();
                break;
            case 'Resep Teruji':
                $recipes = Recipe::where('is_verified', true)->get();
                break;
            default:
                $recipes = collect();
                break;
        }

        return view('recipes.index', compact('recipes'));
    }

    public function favorite()
    {
        if (!auth()->check()) {
            return redirect()->route('login'); // Alihkan ke login jika tidak terautentikasi
        }

        $user = auth()->user(); // Menambahkan pengguna saat ini
        $favorites = $user->favorites;

        return view('favorites.index', compact('user', 'favorites'));
    }



     // Fungsi untuk menambahkan resep ke favorit
     public function addToFavorites($id)
     {
         $user = Auth::user();
         $recipe = Recipe::find($id);

         if ($recipe) {
             // Cek apakah sudah ada di favorit
             if (!$user->favorites()->where('recipe_id', $recipe->id)->exists()) {
                 // Tambahkan ke favorit
                 $user->favorites()->attach($recipe->id);

                 return response()->json(['success' => true, 'message' => 'Resep berhasil ditambahkan ke favorit.']);
             } else {
                 return response()->json(['success' => false, 'message' => 'Resep sudah ada di daftar favorit.']);
             }
         }

         return response()->json(['success' => false, 'message' => 'Resep tidak ditemukan.']);
     }

     // Fungsi untuk menampilkan halaman favorit
     public function showFavorites()
     {
         $user = Auth::user();
         $favorites = $user->favorites; // Ambil semua favorit user

         return view('favorites.index', compact('favorites'));
     }

     public function showIngredients(Request $request)
    {
        // Get the recipes that do not have any ingredients
        $recipes = Recipe::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('ingredients')
                ->join('ingredient_recipe', 'ingredients.id', '=', 'ingredient_recipe.ingredient_id')
                ->whereRaw('recipes.id = ingredient_recipe.recipe_id');
        })->paginate(15);

        $total = $recipes->total(); // Total count of recipes
        $ingredientName = $request->input('ingredient'); // Get the ingredient name from the request

        // Fetch all ingredients from the database
        $ingredients = Ingredient::all(); // Make sure to import the Ingredient model at the top

        return view('bahan.index', compact('recipes', 'total', 'ingredientName', 'ingredients'));
    }

}
