<?php

use App\Http\Controllers\{
    RecipeController, CategorieController, CommentController, FavoriteController,
    Auth\LoginController, SearchController, Auth\RegisterController,
    HomeController, SubcategoryController, ProfileController, TipController
};
use Illuminate\Support\Facades\Route;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Register and Login routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Profile route with auth middleware
Route::middleware('auth')->get('/profile', [ProfileController::class, 'show'])->name('profile.show');

// Recipes routes
Route::prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::middleware('auth')->group(function () {
        Route::get('/create', [RecipeController::class, 'create'])->name('create');
        Route::post('/', [RecipeController::class, 'store'])->name('store');
        Route::get('/{recipe}/edit', [RecipeController::class, 'edit'])->name('edit');
        Route::delete('/{recipe}', [RecipeController::class, 'destroy'])->name('destroy'); 
        Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('update');
    });

    Route::get('/{recipe}', [RecipeController::class, 'show'])->name('show');
    Route::get('/by-type/{type}', [RecipeController::class, 'showByType'])->name('byType');
    Route::get('/recommendation', [RecipeController::class, 'byRecommendation'])->name('byRecommendation');
    Route::get('/by-method/{method}', [RecipeController::class, 'showByMethod'])->name('byMethod');
    Route::get('/by-cuisine/{cuisine}', [RecipeController::class, 'showByCuisine'])->name('byCuisine');
    Route::get('/by-ingredient/{ingredient}', [RecipeController::class, 'showByIngredient'])->name('byIngredient');
    Route::get('/by-purpose/{purpose}', [RecipeController::class, 'showByPurpose'])->name('byPurpose');
    Route::get('/favorite-recipes', [RecipeController::class, 'favorite'])->name('favorite');
});

// Categories and Subcategories routes
Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('/', [CategorieController::class, 'index'])->name('index');
    Route::get('/{categorie}', [CategorieController::class, 'show'])->name('show');
});

// Favorites routes with auth middleware
Route::middleware('auth')->prefix('favorites')->name('favorites.')->group(function () {
    Route::post('/{id}', [FavoriteController::class, 'store'])->name('store');
    Route::get('/', [FavoriteController::class, 'index'])->name('index');
});

// Auth check and redirect URL setting
Route::get('/check-auth', fn() => response()->json(['authenticated' => auth()->check()]));
Route::post('/set-redirect-url', [LoginController::class, 'setRedirectUrl'])->name('set.redirect.url');

// User comments route
Route::get('/user-comments', [CommentController::class, 'index'])->name('user.comments');

// Tips routes with auth middleware
Route::resource('tips', TipController::class)->except(['edit', 'destroy', 'update']);
Route::middleware('auth')->prefix('tips')->name('tips.')->group(function () {
    Route::get('/{tip}/edit', [TipController::class, 'edit'])->name('edit');
    Route::put('/{tip}', [TipController::class, 'update'])->name('update');
    Route::delete('/{tip}', [TipController::class, 'destroy'])->name('destroy');
});

// Ingredient route
Route::get('/ingredients', [RecipeController::class, 'showIngredients'])->name('ingredients.index');
Route::get('/ingredients/{id}', [IngredientController::class, 'show'])->name('ingredients.show');