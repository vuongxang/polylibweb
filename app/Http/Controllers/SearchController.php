<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\AuthorBooks;
use App\Models\Book;
use App\Models\BookGallery;
use App\Models\Category;
use App\Models\CategoryBook;
use App\Models\PostShare;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $a = urldecode($keyword);
        // $shares = Book::join('author_books', 'books.id', '=', 'author_books.book_id')
        //     ->join('authors', 'authors.id', '=', 'author_books.author_id')
        //     ->where('books.title', 'like', '%' . $keyword . '%')
        //     ->orWhere('authors.name', 'like', '%' . $keyword . '%')
        //     ->get();
        $books = Book::where('title', 'like', '%' . $keyword . '%')->where('status', 1)->get();
        // $authors = Author::where('name', 'like', '%' . $request->keyword . '%')->get();
        $categories = Category::where('status', 1)->get();

        $authors = Author::where('name', 'like', '%' . $keyword . '%')->with(['books' => function ($query) {
            $query->where('status', 1);
        }])->get();

        $posts = PostShare::where('title', 'like', '%' . $keyword . '%')->where('status', 1)->get();
        // $books->star = DB::table('ratings')->where('rateable_id', $id)->avg('rating');
        session()->flashInput($request->input());
        return view('client.pages.search', compact('categories', 'books', 'keyword', 'authors', 'posts'));
    }
    public function filter(Request $request)
    {
        $cateFilter = $request->cates;
        $a = urldecode($request->keyword);
        if (!empty($cateFilter)) {
            $numArray = array_map('intval', $request->cates);
            // $authors = Author::where('name', 'like', '%' . $request->keyword . '%')->with(['books' => function ($query) {
            //     $query->where('status', 1);
            // }])->get();
            $auth = Auth::user();
            $books = Book::with('authors', 'rates')
                ->with([
                    'orders' => function ($query) use ($auth) {
                        $query->where('id_user', $auth->id);
                    }
                ])
                ->distinct()

                ->join('category_books', 'books.id', 'category_books.book_id')
                ->join('categories', 'categories.id', 'category_books.cate_id')
                ->select(DB::raw('DISTINCT(books.id),books.*'))
                ->whereIn('categories.id', $numArray)
                // ->where('title', 'like', '%' . $request->keyword . '%')
                ->where('title', 'like', '%' . $a . '%')
                ->where('books.status', 1)

                ->get();
            // ->where('title', 'LIKE', "%\"{$$request->keyword}\"%")
        } else {
            $auth = Auth::user();
            $books = Book::with('authors', 'rates')
                ->with([
                    'orders' => function ($query) use ($auth) {
                        $query->where('id_user', $auth->id);
                    }
                ])
                ->where('title', 'like', '%' . $a . '%')
                ->where('status', 1)
                ->get();
        }

        return response()->json([$books, $a, $auth]);
    }
    public function searchApi(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword) {
            $bookSearch = Book::with('authors')->where('title', 'like', '%' . $keyword . '%')->where('status', 1)
                ->get();
            $authorSearch = Author::with('books')->where('name', 'like', '%' . $keyword . '%')
                ->get();
            $post = PostShare::where('title', 'like', '%' . $keyword . '%')->where('status', 1)->get();
        }
        return response()->json([$bookSearch, $authorSearch, $post]);
    }
}
