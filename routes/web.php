<?php
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return view('home');
});
Route::resource('recipes', RecipeController::class);
Route::resource('categories', CategoryController::class);
Route::post('recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('recipes/{recipe}/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('recipes/{recipe}/favorites', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
