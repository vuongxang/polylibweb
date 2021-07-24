<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;

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
        $infomation->save();
        return back();
    }
    public function history($id){
        $book_order = Order::all();
        $deleted_book_order = Order::onlyTrashed()->get();
        $dt = now();

        // $book_order->load('book');
        return view('client.pages.history', compact('book_order', 'deleted_book_order', 'dt'));
    }

}
