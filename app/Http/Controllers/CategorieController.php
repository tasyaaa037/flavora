<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\CategorieType;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Menampilkan semua kategori
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorieTypes = CategorieType::with('categories')->get();  // Assuming CategorieType has a 'categories' relationship
        return view('kategori.index', compact('categorieTypes'));
    }
    
    /**
     * Menampilkan form untuk menambah kategori
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ambil semua tipe kategori untuk dropdown
        $categorieTypes = CategorieType::all();

        return view('kategori.create', compact('categorieTypes'));
    }

    /**
     * Menyimpan kategori baru
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'categorie_type_id' => 'required|exists:categorie_types,id',
        ]);

        // Membuat kategori baru
        Categorie::create([
            'nama' => $request->nama,
            'categorie_type_id' => $request->categorie_type_id,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit kategori
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Ambil kategori dan tipe kategori untuk form edit
        $category = Categorie::findOrFail($id);
        $categorieTypes = CategorieType::all();

        return view('kategori.edit', compact('category', 'categorieTypes'));
    }

    /**
     * Memperbarui kategori
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'categorie_type_id' => 'required|exists:categorie_types,id',
        ]);

        // Cari kategori yang akan diperbarui
        $category = Categorie::findOrFail($id);
        
        // Perbarui kategori
        $category->update([
            'nama' => $request->nama,
            'categorie_type_id' => $request->categorie_type_id,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus kategori
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Hapus kategori
        $category = Categorie::findOrFail($id);
        $category->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
