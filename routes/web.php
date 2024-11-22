<?php

use App\Http\Controllers\{
    RecipeController, CategorieController, CommentController, FavoriteController,
    Auth\LoginController, SearchController, Auth\RegisterController,
    HomeController, CategoriTypeController, ProfileController, TipController, IngredientController
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

// Profile routes with auth middleware
Route::middleware('auth')->get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::middleware('auth')->get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
Route::delete('/profile/favorite/{recipe}', [ProfileController::class, 'removeFavorite'])->name('profile.favorite.remove');

// Recipes routes
Route::prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::middleware('auth')->group(function () {
        Route::get('/create', [RecipeController::class, 'create'])->name('create');
        Route::post('/', [RecipeController::class, 'store'])->name('store');
        Route::get('/{recipe}/edit', [RecipeController::class, 'edit'])->name('edit');
        Route::put('/{recipe}', [RecipeController::class, 'update'])->name('update');
        Route::delete('/{recipe}', [RecipeController::class, 'destroy'])->name('destroy'); 
        Route::post('/{id}/save', [RecipeController::class, 'save'])->name('save');
    });
    Route::get('/{recipe}', [RecipeController::class, 'show'])->name('show');
    Route::get('/by-type/{type}', [RecipeController::class, 'showByType'])->name('byType');
    Route::get('/by-recommendation/{recommendation}', [RecipeController::class, 'showByRecommendation'])->name('byRecommendation');
    Route::get('/by-method/{method}', [RecipeController::class, 'showByMethod'])->name('byMethod');
    Route::get('/by-cuisine/{cuisine}', [RecipeController::class, 'showByCuisine'])->name('byCuisine');
    Route::get('/by-ingredient/{ingredient}', [RecipeController::class, 'showByIngredient'])->name('byIngredient');
    Route::get('/by-purpose/{purpose}', [RecipeController::class, 'showByPurpose'])->name('byPurpose');
    Route::post('/save-favorite/{recipeId}', [RecipeController::class, 'saveFavorite'])->name('save.favorite');
});

// Favorites routes (auth required)
Route::middleware('auth')->prefix('favorites')->name('favorites.')->group(function () {
    Route::post('/{id}', [FavoriteController::class, 'store'])->name('store');
    Route::get('/', [FavoriteController::class, 'index'])->name('index');
});

// Categories and Subcategories routes
Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('/', [CategorieController::class, 'index'])->name('index');
    Route::get('/{categorie}', [CategorieController::class, 'show'])->name('show');
});

// Comments routes with auth middleware
Route::middleware('auth')->prefix('comments')->name('comments.')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('index');
    Route::get('/recipes/{recipeId}/create', [CommentController::class, 'create'])->name('create');
    Route::post('/recipes/{recipeId}', [CommentController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CommentController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CommentController::class, 'update'])->name('update');
    Route::delete('/{id}', [CommentController::class, 'destroy'])->name('destroy');
});

// Tips routes
Route::resource('tips', TipController::class)->except(['edit', 'destroy', 'update']);
Route::middleware('auth')->prefix('tips')->name('tips.')->group(function () {
    Route::get('/{tip}/edit', [TipController::class, 'edit'])->name('edit');
    Route::put('/{tip}', [TipController::class, 'update'])->name('update');
    Route::delete('/{tip}', [TipController::class, 'destroy'])->name('destroy');
});

// Ingredients routes
Route::prefix('ingredients')->name('ingredients.')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('index');
    Route::get('/search', [IngredientController::class, 'search'])->name('search');
    Route::get('/{ingredient}', [IngredientController::class, 'show'])->name('show');
    Route::get('/form', [IngredientController::class, 'showForm']);
});

// Auth check and redirect URL setting
Route::get('/check-auth', fn() => response()->json(['authenticated' => auth()->check()]));
Route::post('/set-redirect-url', [LoginController::class, 'setRedirectUrl'])->name('set.redirect.url');
