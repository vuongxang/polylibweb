<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

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
        
        return view('client.pages.home', compact('books'));
    }
    public function infomation($id){
        return view('client.pages.infomation');
    }
    public function edit_infomation(Request $request,$id){
        $infomation = User::find($id);
        // $request->offsetUnset('_token');
        // $infomation->update($request->all());
        $infomation->phone = $request->phone;
        $infomation->birth_date = $request->birth_date;
        $infomation->gender = $request->gender;
        // if($request->hasFile('avatar')){
        //     $avatar = $request->file('avatar');
        //     $name_file = $avatar->getClientOriginalName();
        //     $name_avatar = uniqid().'-'.$name_file;
        //     while(file_exists('images/avatar_infomation'.$name_avatar)){
        //         $name_avatar = uniqid().'-'.$name_file;
        //     }
        //     $avatar->move('images/avatar_infomation',$name_avatar);
        //     $infomation->avatar = $name_avatar;
        // }
        $infomation->save();
        return back();
    }
    public function history($id){
        // printf(Carbon::now());
        $book_order = Order::all();
        $books = Order::where('status','Đang mượn')->get();
        $deleted_book = Order::onlyTrashed()->get();
        $dt = now();
        return view('client.pages.history', compact('book_order', 'deleted_book', 'dt', 'books'));
    }

}
