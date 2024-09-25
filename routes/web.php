<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('delfood-1.0.0.index'); // Halaman utama
});

Route::get('/about', function () {
    return view('delfood-1.0.0.about'); // Halaman tentang
});

Route::get('/blog', function () {
    return view('delfood-1.0.0.blog'); // Halaman blog
});

