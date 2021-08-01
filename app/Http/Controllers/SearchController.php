<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\AuthorBooks;
use App\Models\Book;
use App\Models\BookGallery;
use App\Models\Category;
use App\Models\CategoryBook;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $shares = Book::join('author_books', 'books.id', '=', 'author_books.book_id')
            ->join('authors', 'authors.id', '=', 'author_books.author_id')
            ->where('books.title', 'like', '%' . $keyword . '%')
            ->orWhere('authors.name', 'like', '%' . $keyword . '%')
            ->get();
        $books = Book::where('title', 'like', '%' . $request->keyword . '%')->get();
        $categories = Category::all();
        return view('client.pages.search', compact('categories', 'books', 'keyword'))->with('keyword', $keyword);

    }
    public function filter(Request $request)
    {
        $cateFilter = $request->cates;
        if (!empty($cateFilter)) {
            $numArray = array_map('intval', $request->cates);
            $books = Book::with('authors')
                ->distinct()

                ->join('category_books', 'books.id', 'category_books.book_id')
                ->join('categories', 'categories.id', 'category_books.cate_id')
                ->select(DB::raw('DISTINCT(books.id),books.*'))
                ->where('title', 'like', '%' . $request->keyword . '%')
                ->whereIn('categories.id', $numArray)

                ->get();
        } else {
            $books = Book::with('authors')
                ->where('title', 'like', '%' . $request->keyword . '%')
                ->get();
        }

        return response()->json($books);
    }
    public function searchApi(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword) {
            $bookSearch = Book::with('authors')->where('title', 'like', '%' . $keyword . '%')
                ->get();
            $authorSearch = Author::with('books')->where('name', 'like', '%' . $keyword . '%')
                ->get();
        }
        return response()->json([$bookSearch,$authorSearch]);
    }
}
