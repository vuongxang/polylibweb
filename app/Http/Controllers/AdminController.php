<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        $books          = Book::all();
        $categories     = Category::all();
        $authors        = Author::all();
        $comments_pending       = Comment::where('status',0)->get();
        return view('admin.dashboard',[
                'books'         => $books,
                'categories'    => $categories,
                'authors'        => $authors,
                'comments_pending'      => $comments_pending
        ]);
    }

    public function fileManager(){
        return view('admin.file-manager');
    }
}
