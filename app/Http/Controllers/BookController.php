<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\AuthorBooks;
use App\Models\Book;
use App\Models\BookAudio;
use App\Models\BookGallery;
use App\Models\Category;
use App\Models\CategoryBook;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use SebastianBergmann\Environment\Console;
use willvincent\Rateable\Rating as RateableRating;
use Spatie\PdfToImage\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\Constraint\Count;
use Imagick;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Securities\Rates;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 10;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;

        $books = Book::sortable()->where('title', 'like', "%" . $keyword . "%")->orderBy('created_at', 'DESC')->paginate($pagesize);
        $books->load('categories');
        $books->load('authors');
        $books->load('bookGalleries');
        $books->load('bookAudios');
        $books_trashed = Book::onlyTrashed()->paginate(10);
        return view('admin.books.index', compact('books', 'pagesize','books_trashed'));
    }

    public function create()
    {
        $cates = Category::all();
        $authors = Author::all();
        return view('admin.books.add-form', compact('cates', 'authors'));
    }

    public function store(BookRequest $request)
    {
        $model = new Book();

        $model->fill($request->all());

        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->title, '-');

        // $pathToPdf = public_path('kinh-nghiem.pdf');

        // $forder_existed = mkdir(public_path("/uploads/pdf/$model->slug"), 0777);
        // $output_path = public_path("/uploads/pdf/".$model->slug);

        // $pdf = new Pdf($pathToPdf);
        // $number_page = $pdf->getNumberOfPages();
        // for($i=1;$i<=$number_page;$i++){
        //     $pdf->setPage($i)->setCompressionQuality(10)->saveImage($output_path);
        // }
        // die;

        //Check type audio list
        if ($request->list_audio && $request->list_audio != "[]") {
            $list_audio = json_decode($request->list_audio);
            if ($list_audio == null) $list_audio[] = $request->list_audio;
            $pattern = "/\.(?:wav|mp3)$/i";
            foreach ($list_audio as $key => $value) {
                if(!preg_match($pattern, $value)) return back()->with('error_audio','Chỉ cho phép chọn file mp3,av.');
            }
        }
        //check type image list
        if ($request->list_image) {
            $list_image = json_decode($request->list_image);
            if ($list_image == null) $list_image[] = $request->list_image;
            $pattern = "/[a-z0-9\+_\-]+(\\.(?i)(jpeg|jpg|png))$/i";
            foreach ($list_image as $key => $value) {
                if(!preg_match($pattern, $value)) return back()->with('error_image','Chỉ cho phép ảnh định dạng jpeg,jpg,png.');
            }
        }
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
        if ($request->list_audio && $request->list_audio != "[]") {
            $list_audio = json_decode($request->list_audio);
            if ($list_audio == null) $list_audio[] = $request->list_audio;
            foreach ($list_audio as $url) {
                $item = [
                    'book_id' => $model->id,
                    'url' => $url,
                ];
                DB::table('book_audio')->insert($item);
            }
        }

        if ($request->list_image) {
            $list_image = json_decode($request->list_image);
            if ($list_image == null) $list_image[] = $request->list_image;
            foreach ($list_image as $url) {
                $item = [
                    'book_id' => $model->id,
                    'url' => $url,
                ];
                DB::table('book_galleries')->insert($item);
            }
        }

        return redirect(route('book.index'))->with('message', 'Thêm mới sách thành công !')->with('alert-class', 'alert-success');
    }

    public function edit($id)
    {
        $model = Book::find($id);
        $model->load('bookAudios');
        $model->load('bookGalleries');
        $cates = Category::all();
        $authors = Author::all();
        $book_audios = [];
        if($model->bookAudios){
            foreach ($model->bookAudios as $value) {
                $book_audios[] = $value->url;
            }
        }
        $book_galleries = [];
        if($model->bookGalleries){
            foreach ($model->bookGalleries as $value) {
                $book_galleries[] = $value->url;
            }
        }

        if (!$model) return redirect(route('book.index'));
        return view('admin.books.edit-form', [  'model'     => $model, 
                                                'cates'     => $cates, 
                                                'authors'   => $authors,
                                                'book_audios'=> json_encode($book_audios),
                                                'book_galleries' => json_encode($book_galleries)
                                            ]);
    }

    public function update($id, BookRequest $request)
    {
        $model = Book::find($id);
        $model->fill($request->all());
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->title, '-');

        //Check type audio list
        if ($request->list_audio && $request->list_audio != "[]") {
            $list_audio = json_decode($request->list_audio);
            if ($list_audio == null) $list_audio[] = $request->list_audio;
            $pattern = "/\.(?:wav|mp3)$/i";
            foreach ($list_audio as $key => $value) {
                if(!preg_match($pattern, $value)) return back()->with('error_audio','Chỉ cho phép chọn file mp3,av.');
            }
        }
        //check type image list
        if ($request->list_image) {
            $list_image = json_decode($request->list_image);
            if ($list_image == null) $list_image[] = $request->list_image;
            $pattern = "/[a-z0-9\+_\-]+(\\.(?i)(jpeg|jpg|png))$/i";
            foreach ($list_image as $key => $value) {
                if(!preg_match($pattern, $value)) return back()->with('error_image','Chỉ cho phép ảnh định dạng jpeg,jpg,png.');
            }
        }
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
        if ($request->list_audio) {
            BookAudio::where('book_id', $model->id)->delete();
            if($request->list_audio != "[]"){
                $list_audio = json_decode($request->list_audio);
                if ($list_audio == null) $list_audio[] = $request->list_audio;
                foreach ($list_audio as $url) {
                    $item = [
                        'book_id' => $model->id,
                        'url' => $url,
                    ];
                    DB::table('book_audio')->insert($item);
                }
            }
        }

        if ($request->list_image) {
            BookGallery::where('book_id', $model->id)->delete();
            if($request->list_image != "[]"){
                $list_image = json_decode($request->list_image);
                
                if ($list_image == null) $list_image[] = $request->list_image;
                sort($list_image);
                foreach ($list_image as $url) {
                    $item = [
                        'book_id' => $model->id,
                        'url' => $url,
                    ];
                    DB::table('book_galleries')->insert($item);
                }
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
        $books_trashed = Book::onlyTrashed()->where('title', 'like', "%" . $keyword . "%")->paginate(10);
        $books = Book::paginate(10);
        return view('admin.books.trash-list', compact('books_trashed','books'));
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
            BookGallery::where('book_id', $id)->delete();
            CategoryBook::where('book_id', $id)->delete();
            AuthorBooks::where('book_id', $id)->delete();
            BookAudio::where('book_id', $id)->delete();
            Rating::where('rateable_id', $id)->delete();
            Order::where('book_id', $id)->delete();
            Comment::withTrashed()->where('book_id', $id)->forceDelete();
            $model = Book::withTrashed()->where('id', $id)->forceDelete();

            return redirect(route('book.trashlist'))->with('message', 'Xóa sách thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return redirect(route('book.trashlist'))->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }

    public  function bookDetail($slug)
    {

        Carbon::setLocale('vi');

        $book = Book::where('slug', $slug)->where('status',1)->first();
        if (!$book) return abort(404);
        $book->load('categories');
        $book->load('authors');
        $book->load('bookGalleries');
        $book->load('orders');
        $book->load('bookAudios');
        $sameBooks = [];
        foreach ($book->categories as $cate) {
            foreach ($cate->books as $books) {
                if ($books->id !== $book->id && $books->status == 1) {

                    array_push($sameBooks, $books);
                }
            }
        }
        $sameBooksUnique = array_unique($sameBooks);

        $ordered = Order::where('book_id', $book->id)->where('id_user', Auth::user()->id)
            ->where('status', 'Đang mượn')->first();
        $comments = Comment::where('book_id', $book->id)->where('status', 1)->get();
        $rates = Rating::where('rateable_id', $book->id)->where('status', 1)->get();
        $rates->load('user');
        $comments->load('user');
        $arr = [19, 15, 14];


        $avg_rating = DB::table('ratings')->where('rateable_id', $book->id)->avg('rating');

        return view('client.pages.book-detail', ['book' => $book, 'ordered' => $ordered, 'rates' => $rates, 'avg_rating' => $avg_rating, 'sameBooksUnique' => $sameBooksUnique, 'comments' => $comments]);
    }


    public function rateBook($id)
    {
        $ordered = Order::where('book_id', $id)->where('id_user', Auth::user()->id)
            ->where('status', 'Đang mượn')->first();

        $order_deleted = Order::onlyTrashed()->where('id_user', Auth::user()->id)
            ->where('status', 'Đã trả')->first();

        if (!$ordered && !$order_deleted) return redirect()->back(); //Kiểm tra đã mượn sách chưa mới được review sách

        $rate = \willvincent\Rateable\Rating::where('rateable_id', $id)->where('user_id', Auth::user()->id)->first();
        if (!$rate) $rate = new \willvincent\Rateable\Rating;
        $book = Book::find($id);
        return view('client.pages.review', ['book' => $book, 'rate' => $rate]);
    }

    public function bookStar(Request $request)
    {

        $id = $request->id;
        $ordered = Order::where('book_id', $id)->where('id_user', Auth::user()->id)
            ->where('status', 'Đang mượn')->first();

        $order_deleted = Order::onlyTrashed()->where('id_user', Auth::user()->id)
            ->where('status', 'Đã trả')->first();

        if (!$ordered && !$order_deleted) return redirect()->back();

        request()->validate(['rate' => 'required']);

        $book = Book::find($request->id);

        $body = $request->body;

        $rate = \willvincent\Rateable\Rating::where('rateable_id', $id)->where('user_id', Auth::user()->id)->first();
        if ($rate) $rating = $rate;
        else $rating = new \willvincent\Rateable\Rating;

        $rating->rating = $request->rate;
        $rating->user_id = auth()->user()->id;
        $rating->body = $body;
        $rating->status = 0;
        $book->ratings()->save($rating);

        return redirect(route('user.history', Auth::user()->id))->with('message', 'Gửi đánh giá thành công !');
    }

    public function readingBook($slug)
    {
        $book = Book::where('slug', '=', $slug)->where('status',1)->first();

        if (!$book) return abort(404);
        $ordered = Order::where('book_id', $book->id)->where('id_user', Auth::user()->id)
            ->where('status', 'Đang mượn')->first();

        if (!$ordered) return redirect()->back(); //Check xem đã mượn sách chưa nếu chưa thì không cho truy cập


        if ($book) {
            $pages = BookGallery::where('book_id', '=', $book->id)->orderBy('url', 'ASC')->get();
            return view('client.pages.reading-book', ['pages' => $pages], ['book' => $book]);
            // return view('client.pages.reading', ['pages' => $pages], ['book' => $book]);
        } else {
            return abort(404);
        }
    }

    public function reviewBook($slug)
    {
        $book = Book::where('slug', '=', $slug)->where('status',1)->first();

        if ($book) {
            $pages = BookGallery::where('book_id', '=', $book->id)->take(10)->orderBy('url', 'ASC')->get();
            return view('client.pages.reading-book', ['pages' => $pages], ['book' => $book]);
        } else {
            return abort(404);
        }
    }


    public function getBooks()
    {
        $books = Book::where('status', 1)->paginate(9);
        $categories = Category::where('status',1)->get();
        $categories->loadCount(['books' => function ($query) {
            $query->where('status', 1);
        }]);
        return view('client.pages.category', compact('categories', 'books'));
    }
    public function getBooksByCategory($slug)
    {


        $books = Book::whereHas('categories', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->where('status', 1)->paginate(9);
        $cateName = Category::firstWhere('slug', $slug)->name;

        $categories = Category::all();
        $categories->loadCount(['books' => function ($query) {
            $query->where('status', 1);
        }]);
        if (count($books) > 0) {
            return view('client.pages.category')->with(['categories' => $categories, 'books' => $books, 'cateName' => $cateName])->with('message', 'Có ' .count($books) . ' cuốn sách thuộc '. $cateName );
        } else {
            return view('client.pages.category')->with(['categories' => $categories, 'books' => $books])->with('message', 'Danh mục chưa có cuốn sách nào');
        }
    }
}
