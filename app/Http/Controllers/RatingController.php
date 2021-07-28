<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $keyword = $request->keyword;
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
}
