<?php
namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\CategorieType;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        // This ensures that $request is available for use
        $ingredients = Ingredient::all();
        $categorieTypes = CategorieType::with('categories')->get();
    
        // Fetch the search query from the request
        $search = $request->input('search');
    
        // Get all ingredients, but filter if a search query is provided
        if ($search) {
            // Find ingredients that match the search term
            $ingredients = Ingredient::where('name', 'like', '%' . $search . '%')->get();
        } else {
            // If no search term, get all ingredients
            $ingredients = Ingredient::all();
        }
    
        // Group ingredients by the first letter
        $groupedIngredients = $ingredients->groupBy(function ($ingredient) {
            return strtoupper(substr($ingredient->name, 0, 1));
        });
    
        return view('ingredients.index', compact('ingredients', 'groupedIngredients', 'categorieTypes'));
    }
    

    public function search(Request $request)
    {
        $ingredientIds = $request->input('ingredients', []);
        $categorieTypes = CategorieType::all();
    
        // Cari resep berdasarkan bahan
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredientIds) {
            // Specify the table to avoid ambiguity
            $query->whereIn('ingredients.id', $ingredientIds); // Change here
        })->get();
        $search = $request->input('search');

        // Get ingredients based on search query
        $ingredients = Ingredient::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get();
    
        // Group ingredients by the first letter
        $groupedIngredients = $ingredients->groupBy(function ($ingredient) {
            return strtoupper(substr($ingredient->name, 0, 1));
        });
    
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'ingredientsList' => view('ingredients.partials.ingredients_list', compact('groupedIngredients'))->render(),
            ]);
        }

        $searchQuery = $request->get('search');
        $ingredients = Ingredient::where('name', 'like', '%' . $searchQuery . '%')->get();
    
        return response()->json([
            'ingredients' => $ingredients,
            'ingredientsHtml' => view('ingredients.partials.list', compact('ingredients'))->render(),
        ]);
    
        return view('ingredients.results', compact('recipes', 'categorieTypes', 'groupedIngredients'));
    }
    
    public function showForm()
    {
        $ingredients = Ingredient::all();

        // Group ingredients by their first letter
        $groupedIngredients = $ingredients->groupBy(function ($ingredient) {
            return strtoupper(substr($ingredient->name, 0, 1)); // Group by the first letter of the name
        });

        return view('ingredients.form', compact('groupedIngredients'));
    }

    // In IngredientController.php
    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('ingredients.show', compact('ingredient'));
    }

}
