<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        return back()->with('message','Cập nhật thông tin tài khoản thành công');
    }
    public function history($user_id){
        if(Auth::user()->id != $user_id)  return back(); //Check đúng tài khoản đang đăng nhập
        
        $book_order = Order::where('id_user',$user_id)->get();
        $deleted_book_order = Order::onlyTrashed()->where('id_user',$user_id)->paginate(8);
        $dt = now();

        $book_order->load('book');
        return view('client.pages.history', compact('book_order', 'deleted_book_order', 'dt'));
    }
    public function rate($id){
        return view('client.pages.rating');
    }
}
