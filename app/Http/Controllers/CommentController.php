<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Recipe;

class CommentController extends Controller
{
    // Menampilkan semua komentar pengguna
    public function index()
    {
        $user = auth()->user();
        $comments = $user->comments;

        return view('comments.index', compact('user', 'comments'));
    }

    // Menampilkan form untuk menambahkan komentar
    public function create($recipeId)
    {
        $recipe = Recipe::findOrFail($recipeId); // Ambil resep berdasarkan ID
        return view('comments.create', compact('recipe'));
    }

    // Menyimpan komentar baru
    public function store(Request $request, $recipeId)
    {
        $recipe = Recipe::findOrFail($recipeId);

        $request->validate([
            'content' => 'required|max:500',
        ]);

        // Menyimpan komentar
        $comment = new Comment();
        $comment->user_id = auth()->id(); // Menyimpan ID user yang login
        $comment->recipe_id = $recipe->id;
        $comment->content = $request->content;
        $comment->save();

        // Ambil data pengguna untuk menampilkan di komentar
        $user = auth()->user();

        // Jika request AJAX, kirimkan respons JSON
        if ($request->ajax()) {
            return response()->json([
                'userName' => $user->name,
                'userProfileImage' => $user->profile_image ? asset('images/profile/' . $user->profile_image) : asset('images/default-profile.png'),
                'commentContent' => $comment->content,
            ]);
        }

        // Redirect ke halaman resep jika bukan AJAX
        return redirect()->route('recipes.show', $recipe->id)->with('success', 'Komentar berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit komentar
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment); // Pastikan pengguna memiliki akses

        return view('comments.edit', compact('comment'));
    }

    // Mengupdate komentar
    public function update(Request $request, Comment $comment)
    {
        // Pastikan pengguna memiliki akses untuk memperbarui komentar ini
        $this->authorize('update', $comment);

        // Validasi data input dan langsung update
        $comment->update($request->validate([
            'content' => 'required|string|min:5|max:500',
        ]));

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil diperbarui.');
    }

    // Menghapus komentar
    public function destroy(Comment $comment)
    {
        // Pastikan pengguna memiliki akses untuk menghapus komentar ini
        $this->authorize('delete', $comment);

        // Hapus komentar
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil dihapus.');
    }
}