<?php
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

Route::resource('recipes', RecipeController::class);
Route::resource('categories', CategoryController::class);
Route::post('recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('recipes/{recipe}/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('recipes/{recipe}/favorites', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
