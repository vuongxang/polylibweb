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

        $book_order = Order::where('id_user',Auth::user()->id)->get();
        // dd(count($book_order));
        // if(Auth::user()->role_id==4){
        //     if(count($book_order)>=5) return redirect(route('user.history',Auth::user()->id))
        //             ->with('message','Bạn chỉ được mượn tối đa 5 quyển sách')
        //             ->with('alert','alert-danger');
        // }elseif(Auth::user()->role_id==3){
        //     if(count($book_order)>=10) return redirect(route('user.history',Auth::user()->id))
        //             ->with('message','Bạn chỉ được mượn tối đa 10 quyển sách')
        //             ->with('alert','alert-danger');
        // }
        if(count($book_order)>=5) return redirect(route('user.history',Auth::user()->id))
                    ->with('message','Bạn chỉ được mượn tối đa 5 quyển sách')
                    ->with('alert','alert-danger');

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
        return back()->with('message','Đã trả sách thành công');
    }
}
