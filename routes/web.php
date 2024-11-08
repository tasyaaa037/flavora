<?php
use App\Http\Controllers\{
    RecipeController, CategoryController, CommentController, FavoriteController,
    Auth\LoginController, SearchController, Auth\RegisterController,
    HomeController, SubcategoryController, ProfileController, TipController
};
use Illuminate\Support\Facades\Route;

// Home routes
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Register and Login routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Profile route with auth middleware
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

// Recipes and Subcategory routes
Route::resource('recipes', RecipeController::class)->except(['show']);
Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store'); // Explicitly adding store route
Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
Route::get('/subcategories/{id}', [SubcategoryController::class, 'show'])->name('subcategories.show');

// Additional Recipe filtering routes
Route::get('/recipes/type/{type}', [RecipeController::class, 'byType'])->name('recipes.byType');
Route::get('/recipes/method/{method}', [RecipeController::class, 'showByMethod'])->name('recipes.byMethod');
Route::get('/recipes/by-cuisine/{cuisine}', [RecipeController::class, 'byCuisine'])->name('recipes.byCuisine');
Route::get('/recipes/by-ingredient/{ingredient}', [RecipeController::class, 'byIngredient'])->name('recipes.byIngredient');
Route::get('/recipes/purpose/{purpose}', [RecipeController::class, 'byPurpose'])->name('recipes.byPurpose');
Route::get('/recipes/recommendation/{type}', [RecipeController::class, 'byRecommendation'])->name('recipes.byRecommendation');

// Favorite routes with auth middleware
Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->middleware('auth')->name('favorites.store');
Route::get('/favorites', [FavoriteController::class, 'index'])->middleware('auth')->name('favorites.index');
Route::get('/favorite-recipes', [RecipeController::class, 'favorite'])->middleware('auth')->name('favorite.recipes');

// Auth check and redirect URL setting
Route::get('/check-auth', function () { return response()->json(['authenticated' => auth()->check()]); });
Route::post('/set-redirect-url', [LoginController::class, 'setRedirectUrl'])->name('set.redirect.url');

// User comments route
Route::get('/user-comments', [CommentController::class, 'index'])->name('user.comments');

// Tip routes
Route::resource('tips', TipController::class)->except(['edit', 'destroy', 'update']);
Route::post('/tips', [TipController::class, 'store'])->name('tips.store')->middleware('auth'); // Adding store route for tips
Route::get('/tips/{id}/edit', [TipController::class, 'edit'])->name('tips.edit')->middleware('auth');
Route::put('/tips/{id}', [TipController::class, 'update'])->name('tips.update')->middleware('auth');
Route::delete('/tips/{id}', [TipController::class, 'destroy'])->name('tips.destroy')->middleware('auth');

// Ingredient route
Route::get('/bahan', [RecipeController::class, 'showIngredients'])->name('bahan.index');
