<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PostShare;
use App\Models\Wishlist;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist($id, Request $request){
        $model = new Wishlist();
        $model->post_id = $request->id;
        $model->user_id = Auth::user()->id;
        $model->status = 'Đã thêm';
        $model->save();
        return back();
    }
    public function destroy($id){
        $model = Wishlist::where('post_id',$id);
        if (!$model) return back()->with('message','Dữ liệu không tồn tại');
        $model->delete();

        return back()->with('message','Xóa khỏi yêu thích thành công !');
    }
}
