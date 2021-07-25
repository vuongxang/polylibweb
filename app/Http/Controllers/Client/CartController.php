<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use Cart;
use Session;

class CartController extends Controller
{
    public function getListCart(Request $request){
        $total = Cart::subtotalFloat();
        $listSP = Cart::content();
        $user = User::where('id', 1)->get();
        $date = Carbon::now();
        $date->addDay(15, 'Y-m-d');
        return view('main.cart', compact('listSP', 'total', 'date', 'user'));
    }
    public function getAddCart($id){
        $book = Book::find($id);
        $addCart = Cart::add(['id' => $id, 'name' => $book->title, 'options' => ['image' => $book->image]]);
        // dd($addCart);
        $order = new Order;
        $order->id_user = Auth::user()->id;
        $order->book_id = $book->id;
        $order->status = 'Đang mượn';

        $order->save();

        Session::forget('cart');
        return back()->with('thongbao','Mượn sách thành công');
    }
    public function deleted_book($id){
        $order = Order::find($id);
        $order->status = 'Đã trả';
        $order->save();
        Order::find($id)->delete();
        return back()->with('deleted_book','Đã trả sách thành công');
    }
}
