<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Cart;

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
        $product = Book::find($id);
        $addCart = Cart::add(['id' => $id, 'name' => $product->name, 'qty' => 1, 'options' => ['image' => $product->image]]);
        // dd($addCart);
        return back()->with('thongbao','Sản phẩm đã được thêm vào giỏ hàng');
    }
}
