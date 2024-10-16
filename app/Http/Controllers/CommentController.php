<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $user = auth()->user(); 
        $comments = $user->comments; 

        return view('comments.index', compact('user', 'comments')); // Kirim data user dan favorites ke view
    }
}
