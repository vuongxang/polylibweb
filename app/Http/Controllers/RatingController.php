<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request){
        $pagesize = 10;
        $keyword = $request->keyword;
        if ($request->page_size) $pagesize = $request->page_size;
        
        $ratings_approved = Rating::sortable()->where('body','like','%'.$keyword.'%')
                            ->where('status',1)->orderBy('created_at','DESC')->paginate($pagesize);
        $ratings_pending = Rating::sortable()->where('body','like','%'.$keyword.'%')
                            ->where('status',0)->orderBy('created_at','DESC')->paginate($pagesize);
        $ratings_deleted = Rating::onlyTrashed()->where('body','like','%'.$keyword.'%')
                            ->orderBy('created_at','DESC')->paginate($pagesize);

        return view('admin.ratings.index',[
                                            'ratings_approved'  =>  $ratings_approved,
                                            'ratings_pending'   =>  $ratings_pending,
                                            'ratings_deleted'   =>  $ratings_deleted,
                                            'pagesize'          =>  $pagesize
                                        ]);
    }

    public function rateApprov($id){
        $rate = Rating::find($id);
        if(!$rate) return back();
        $rate->status = 1;
        $rate->save();
        return redirect(route('rate.index'))->with('message','Xét duyệt đánh giá thành công')
                                                ->with('alert-class','alert-success');
    }

    public function destroy($id){
        $model = Rating::find($id);
        if($model){
            Rating::destroy($id);
            return redirect(route('rate.index'))->with('message','Chuyển vào thùng rác thành công !')
                                                ->with('alert-class','alert-success');
        }else{
            return redirect(route('rate.index'))->with('message','Dữ liệu không tồn tại !')
                                                ->with('alert-class','alert-danger');
        }
    }

    public function restore($id){
        Rating::withTrashed()->where('id', $id)->restore();
        return redirect(route('rate.index'))->with('message','Khôi phục thành công')
                                                    ->with('alert-class','alert-success');
    }

    public function forceDelete($id){
      
        $model = Rating::withTrashed()->find($id);
        if($model){
            $model = Rating::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('rate.index'))->with('message','Xóa bình luận thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return redirect(route('rate.index'))->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }
}
