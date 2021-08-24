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
        $books = Book::orderBy('publish_date_from', 'DESC')->take(8)->get();
        $books->load('categories');
        $books->load('authors');
        $books->load('bookGalleries');
        $books->load('orders');
        return view('client.pages.home', compact('books'));
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
            $infomation->avatar = 'storage/'.$filePath;
        }

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
