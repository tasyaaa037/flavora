<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\CategorieType;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        // Fetch categories or categorieTypes from the database
        $categorieTypes = CategorieType::with('categories')->get();

        // Pass the data to the view
        return view('kategori.index', compact('categorieTypes'));
    }


    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Categorie::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Category created successfully.');
    }
}
