<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\AuthorBooks;
use App\Models\Book;
use App\Models\BookGallery;
use App\Models\Category;
use App\Models\CategoryBook;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use SebastianBergmann\Environment\Console;
use willvincent\Rateable\Rating as RateableRating;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 5;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;

        $books = Book::sortable()->where('title', 'like', "%" . $keyword . "%")->paginate($pagesize);
        $books->load('categories');
        $books->load('authors');
        $books->load('bookGalleries');
        $books->load('bookAudio');

        return view('admin.books.index', compact('books', 'pagesize'));
    }

    public function create()
    {
        $cates = Category::all();
        $authors = Author::all();
        return view('admin.books.add-form', compact('cates', 'authors'));
    }

    public function store(Request $request){
        $model = new Book();

        $model->fill($request->all());
        // dd($request->all());
        $model->slug = str_slug($request->title, '-');
        $model->save();

        if ($request->cate_id) {
            foreach ($request->cate_id as $cate_id) {
                $item = [
                    'cate_id' => $cate_id,
                    'book_id' => $model->id
                ];
                DB::table('category_books')->insert($item);
            }
        }

        if ($request->author_id) {
            foreach ($request->author_id as $author_id) {
                $item = [
                    'author_id' => $author_id,
                    'book_id' => $model->id
                ];
                DB::table('author_books')->insert($item);
            }
        }

        if ($request->list_image) {
            $list_image = json_decode($request->list_image);
            foreach ($list_image as $url) {
                $item = [
                    'book_id' => $model->id,
                    'url' => $url,
                ];
                DB::table('book_galleries')->insert($item);
            }
        }

        return redirect(route('book.index'))->with('message', 'Thêm mới sách thành công !');
    }

    public function edit($id)
    {
        $model = Book::find($id);
        $cates = Category::all();
        $authors = Author::all();

        if (!$model) return redirect(route('book.index'));
        return view('admin.books.edit-form', ['model' => $model, 'cates' => $cates, 'authors' => $authors,]);
    }

    public function update($id, Request $request)
    {
        $model = Book::find($id);
        $model->fill($request->all());
        // dd($request->all());
        $model->slug = str_slug($request->title, '-');
        $model->save();

        CategoryBook::where('book_id', $model->id)->delete();
        AuthorBooks::where('book_id', $model->id)->delete();

        if ($request->cate_id) {
            foreach ($request->cate_id as $cate_id) {
                $item = [
                    'cate_id' => $cate_id,
                    'book_id' => $model->id
                ];
                DB::table('category_books')->insert($item);
            }
        }

        if ($request->author_id) {
            foreach ($request->author_id as $author_id) {
                $item1 = [
                    'author_id' => $author_id,
                    'book_id' => $model->id
                ];
                DB::table('author_books')->insert($item1);
            }
        }

        if ($request->list_image) {
            $list_image = json_decode($request->list_image);
            foreach ($list_image as $url) {
                $item = [
                    'book_id' => $model->id,
                    'url' => $url,
                ];
                DB::table('book_galleries')->insert($item);
            }
        }

        return redirect(route('book.index'))->with('message', 'Cập nhật thành công !')->with('alert-class', 'alert-success');
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return redirect(route('book.index'))->with('message', 'Chuyển vào thùng rác thành công !')
            ->with('alert-class', 'alert-success');
    }

    public function changeStatus(Request $request)
    {
        $model = Book::find($request->id);
        $model->status = $request->status;
        $model->save();

        return response()->json(['success' => 'Book status change successfully!']);
    }

    public function trashList(Request $request)
    {

        $keyword = $request->keyword;
        $books = Book::onlyTrashed()->where('title', 'like', "%" . $keyword . "%")->paginate(5);
        return view('admin.books.trash-list', compact('books'));
    }

    public function restore($id)
    {
        Book::withTrashed()->where('id', $id)->restore();
        return redirect(route('book.trashlist'))->with('message', 'Khôi phục thành công')
            ->with('alert-class', 'alert-success');
    }

    public function forceDelete($id)
    {

        $model = Book::withTrashed()->find($id);

        if ($model) {
            $model = Book::withTrashed()->where('id', $id)->forceDelete();
            BookGallery::where('book_id', $id)->delete();
            return redirect(route('book.trashlist'))->with('message', 'Xóa sách thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return redirect(route('book.trashlist'))->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }

    public  function bookDetail($id)
    {
        $book = Book::find($id);
        if (!$book) return redirect(route('home'));
        $book->load('categories');
        $book->load('authors');
        $book->load('bookGalleries');

        
        $ordered = Order::where('book_id',$id)->where('id_user',Auth::user()->id)
                                ->where('status','Đang mượn')->first();
        
        $rates = Rating::where('rateable_id',$id)->get();
        $rates->load('user');

        $avg_rating = DB::table('ratings')->where('rateable_id',$id)->avg('rating');
    
        return view('client.pages.book-detail', ['book' => $book,'ordered' => $ordered,'rates'=>$rates,'avg_rating'=>$avg_rating]);
    }


    public function reviewPage($id){
        $ordered = Order::where('book_id',$id)->where('id_user',Auth::user()->id)
                                ->where('status','Đang mượn')->first();

        $order_deleted = Order::onlyTrashed()->where('id_user',Auth::user()->id)
        ->where('status','Đã trả')->first();

        if(!$ordered && !$order_deleted) return redirect()->back(); //Kiểm tra đã mượn sách chưa mới được review sách

        $rate = \willvincent\Rateable\Rating::where('rateable_id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$rate) $rate = new \willvincent\Rateable\Rating; 
        $book = Book::find($id);
        return view('client.pages.review',['book'=>$book,'rate'=>$rate]);
    }

    public function bookStar (Request $request) {

        $id = $request->id;
        $ordered = Order::where('book_id',$id)->where('id_user',Auth::user()->id)
                                ->where('status','Đang mượn')->first();

        $order_deleted = Order::onlyTrashed()->where('id_user',Auth::user()->id)
        ->where('status','Đã trả')->first();

        if(!$ordered && !$order_deleted) return redirect()->back();

        request()->validate(['rate' => 'required']);

        $book = Book::find($request->id);

        $body = $request->body;

        $rate = \willvincent\Rateable\Rating::where('rateable_id',$id)->where('user_id',Auth::user()->id)->first();
        if($rate) $rating = $rate;
        else $rating = new \willvincent\Rateable\Rating;
        
        $rating->rating = $request->rate;
        $rating->user_id = auth()->user()->id;
        $rating->body = $body;
        $book->ratings()->save($rating);

        return redirect(route('user.history',Auth::user()->id))->with('message','Gửi đánh giá thành công !');
    }

    public function readingBook($id)
    {
        $ordered = Order::where('book_id',$id)->where('id_user',Auth::user()->id)
                                                ->where('status','Đang mượn')->first();

        if(!$ordered) return redirect()->back(); //Check xem đã mượn sách chưa nếu chưa thì không cho truy cập

        $book = Book::find($id);
        if ($book) {
            $pages = BookGallery::where('book_id', '=',$book->id)->orderBy('id','desc')->get();
            return view('client.pages.reading-book', ['pages' => $pages], ['book' => $book]);
        } else {
            return abort(404);
        }
    }


    public function getBooks(){
        $books = Book::paginate(9);
        $categories = Category::all();
        return view('client.pages.category',compact('categories','books'));

    }
    public function getBooksByCategory($slug){
        $catee= Category::where('slug', '=',$slug)->get();
        $catee->load('books');
        $categories = Category::all();
        $array = [];
        foreach($catee as $a){
            foreach($a->books as $b){
                array_push($array,$b);
            }
        }
        return view('client.pages.category',compact('categories','catee'));
  }
}
