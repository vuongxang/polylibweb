<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookMark;
use App\Models\User;
use Illuminate\Http\Request;

class BookMarkController extends Controller
{
    public function addBookMark(Request $request)
    {
        $page = intval($request->page);
        $book_slug = intval($request->book_slug);
        $user_id = intval($request->user_id);
        $book = Book::where('slug', $book_slug)->where('status', 1)->first();
        $user = User::where('id', $user_id)->first();

        $bookmark = new BookMark();
        $bookmark->book_id = $book->id;
        $bookmark->user_id = $user->id;
        $bookmark->page = $page;
        $bookmark->save();


        return response()->json([
            "message" => "Trang " . $page . " đã thêm bookmark",
        ]);
    }
    public function removeBookMark(Request $request)
    {
        $page = intval($request->page);
        $book_slug = intval($request->book_slug);
        $user_id = intval($request->user_id);
        $book = Book::where('slug', $book_slug)->where('status', 1)->first();
        $user = User::where('id', $user_id)->first();

        BookMark::where('book_id',$book->id)->where('page',$page)->where('user_id',$user->id)->delete();
        // $bookmark = new BookMark();
        // $bookmark->book_id = $book->id;
        // $bookmark->user_id = $user->id;
        // $bookmark->page = $page;
        // $bookmark->save();


        return response()->json([
            "message" => "Trang " . $page . " đã  xóa bookmark",
        ]);
    }
}
