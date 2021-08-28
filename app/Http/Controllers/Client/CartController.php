<?php

namespace App\Http\Controllers\Client;

use App\Events\NewNotificationEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Notifications\CommentNotification;
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
        if(!$book) return back()
                            ->with('message','sách không tồn tại !')
                            ->with('alert','alert-danger')->with('text-alert','text-danger');
        if($book->status==0) return back()
                            ->with('message','Hiện bạn không thể mượn cuốn sách này !')
                            ->with('alert','alert-danger')->with('text-alert','text-danger');
        $book_order = Order::where('id_user',Auth::user()->id)->get();
        $is_ordered = Order::where('id_user',Auth::user()->id)->where('book_id',$id)->first();
        if($is_ordered) return back()
                            ->with('message','Bạn đã mượn cuốn sách này trước đó !')
                            ->with('alert','alert-danger')->with('text-alert','text-danger');

        if(Auth::user()->role_id==4){
            if(count($book_order)>=10) return back()
                                ->with('message','Bạn chỉ được mượn tối đa 10 quyển sách')
                                ->with('alert','alert-danger')->with('text-alert','text-danger');
        }elseif(Auth::user()->role_id==3){
            if(count($book_order)>=20) return back()
                                ->with('message','Bạn chỉ được mượn tối đa 20 quyển sách')
                                ->with('alert','alert-danger')->with('text-alert','text-danger');
        }else{
            if(count($book_order)>=10) return back()
                                ->with('message','Bạn chỉ được mượn tối đa 10 quyển sách')
                                ->with('alert','alert-danger')->with('text-alert','text-danger');
        }

        $addCart = Cart::add(['id' => $id, 'name' => $book->title, 'options' => ['image' => $book->image]]);
        // dd($addCart);
        $order = new Order;
        $order->id_user = Auth::user()->id;
        $order->book_id = $book->id;
        $order->status = 'Đang mượn';

        $order->save();


        $borrowBookNotify = [
            'avatar'    => $order->user->avatar,
            'title'     => 'Mượn sách thành công',
            'content'   => $order->book->title." đã được thêm vào kho sách của bạn" ,
            'book_id'   => $order->book_id
        ];
        Auth::user()->notify(new CommentNotification($borrowBookNotify));
        
        
        $users = User::where('role_id',1)->orWhere('role_id',2)->get();
        
        $data = [
            'avatar'    => $order->user->avatar,
            'title'     => 'Mượn sách',
            'content'   => $order->user->name." đã mượn sách " . $order->book->title ,
            'book_id'   => $order->book_id
        ];

        

        // foreach ($users as $key => $user) {
        //     $user->notify(new CommentNotification($data)); 
        //     $newNotify = $user->notifications->sortByDesc('created_at')->first();
        //     event(new NewNotificationEvent($newNotify,$user));
        // }

        Session::forget('cart');
        return back()->with('message','Mượn sách thành công')->with('alert','alert-success')
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
