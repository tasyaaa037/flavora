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
    public function index(Request $request)
    {
        $recipes = Recipe::with(['categories', 'subcategory', 'purpose'])->get();
        
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

    // Menampilkan detail resep
    // Menampilkan detail resep
    public function show($id)
    {
        $recipe = Recipe::with(['ingredients', 'steps', 'comments.user', 'categories', 'subcategory', 'purpose'])->findOrFail($id);
        return view('recipes.show', compact('recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image',
            'time' => 'required|integer',
            'price' => 'required|numeric',
            'servings' => 'required|integer',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
        ]);

        try {
            // Assuming you have the Recipe model to save data
            $recipe = new Recipe();
            $recipe->title = $request->title;
            $recipe->description = $request->description;
            $recipe->time = $request->time;
            $recipe->price = $request->price;
            $recipe->servings = $request->servings;
            $recipe->ingredients = $request->ingredients;
            $recipe->steps = $request->steps;
            
            // Handle file upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $recipe->image = $imagePath;
            }
            
            $recipe->save();

            return redirect()->route('recipes.index')->with('success', 'Resep berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan resep. Silakan coba lagi.');
        }
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
