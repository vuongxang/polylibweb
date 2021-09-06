<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::where('status',1)->orderBy('created_at', 'DESC')->take(8)->get();
        $books->load('categories','authors','bookGalleries','orders');
        // Order::with('book')
        // ->select('book_id', DB::raw('COUNT(book_id) as count'))
        
        // ->groupBy('book_id')
        // ->orderBy('count', 'desc')
        // ->take(10)->get();

        $mostBorrowBooks = Book::join('orders','books.id', '=','orders.book_id')
        ->select( DB::raw('COUNT(book_id) as count'),'books.*')
        ->where('books.status',1)
        ->groupBy('books.id' ,'books.title','books.status','books.description','books.publish_date_from','books.image','books.slug','books.created_at','books.deleted_at','books.updated_at')
        ->orderBy('count', 'desc')
        ->take(8)->get();
        return view('client.pages.home', compact('books','mostBorrowBooks'));
    }


    public function profile($id)
    {
        return view('client.pages.profile');
    }



    public function edit_infomation(Request $request, $id)
    {
        $infomation = User::find($id);
        if($request->hasFile('avatar')){
            
            $fileName = uniqid().'_'.$request->file('avatar')->getClientOriginalName();
            $filePath = $request->file('avatar')->storeAs('uploads', $fileName, 'public');
            $infomation->avatar = URL::to('/').'/storage/'.$filePath;
        }
        $infomation->name = $request->name;
        $infomation->phone = $request->phone;
        $infomation->birth_date = $request->birth_date;
        $infomation->gender = $request->gender;
        $infomation->save();
        return back()->with('message', 'Cập nhật thông tin tài khoản thành công');
    }


    public function history($user_id)
    {
        if (Auth::user()->id != $user_id)  return back(); //Check đúng tài khoản đang đăng nhập

        $book_order = Order::where('id_user', $user_id)->get();
        $deleted_book_order = Order::onlyTrashed()->where('id_user', $user_id)->get();
        $dt = Carbon::now();

        $limit = Carbon::now()->addDays(7);
        // dd($limit);
        $inactive_date = Order::where('created_at', '<', $limit)->get();

        // dd((Carbon::now()->addDay(10))->diffInHours(Carbon::now()));
        $book_order->load('book');
        return view('client.pages.history', compact('book_order', 'deleted_book_order', 'dt', 'inactive_date'));
    }
    public function rate($id)
    {
        $user_rating = Rating::where('user_id', $id)->get();
        $avg_rating = DB::table('ratings')->where('rateable_id', $id)->avg('rating');

        $rating = Rating::all();
        $order = Order::all();

        // dd($user_rating);
        return view('client.pages.rating', compact('user_rating', 'avg_rating', 'rating', 'order'));
    }
}
