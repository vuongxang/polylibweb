<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Notifications\InvoicePaid;
use Cart;
use Pusher\Pusher;
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

        if(Auth::user()->role_id==4){
            if(count($book_order)>=5) return back()
                                ->with('thongbao','Bạn chỉ được mượn tối đa 5 quyển sách')
                                ->with('alert','alert-danger')->with('text-alert','text-danger');
        }elseif(Auth::user()->role_id==3){
            if(count($book_order)>=10) return back()
                                ->with('thongbao','Bạn chỉ được mượn tối đa 10 quyển sách')
                                ->with('alert','alert-danger')->with('text-alert','text-danger');
        }else{
            if(count($book_order)>=5) return back()
                                ->with('thongbao','Bạn chỉ được mượn tối đa 5 quyển sách')
                                ->with('alert','alert-danger')->with('text-alert','text-danger');
        }

        $addCart = Cart::add(['id' => $id, 'name' => $book->title, 'options' => ['image' => $book->image]]);
        // dd($addCart);
        $order = new Order;
        $order->id_user = Auth::user()->id;
        $order->book_id = $book->id;
        $order->status = 'Đang mượn';

        $order->save();

        $users = User::where('role_id',1)->orWhere('role_id',2)->get();
        
        $data = [
            'title'     => 'Mượn sách',
            'content'   => $order->user->name." Đã mượn sách <a href=".route('book.detail',$order->book_id).">" .$order->book->title."</a>",
            'icon-class'=> 'icon-circle',
            'book_id'   => $order->book_id
        ];

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('NotificationEvent', 'send-message', $data);
        foreach ($users as $key => $user) {
            $user->notify(new InvoicePaid($data)); 
        }

        Session::forget('cart');
        return back()->with('thongbao','Mượn sách thành công')->with('alert','alert-success')
                        ->with('text-alert','text-success');
    }
    public function deleted_book($id){
        $order = Order::find($id);
        $order->status = 'Đã trả';
        $order->save();
        Order::find($id)->delete();
        return back()->with('message','Đã trả sách thành công');
    }
}
