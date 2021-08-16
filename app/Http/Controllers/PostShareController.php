<?php

namespace App\Http\Controllers;

use App\Models\PostShare;
use App\Models\PostShareCategory;
use App\Models\PostView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostShareController extends Controller
{
    public function all(){
        $cates = PostShareCategory::all();
        $cates->load('posts');
        $posts = PostShare::where('status',1)->orderBy('created_at','DESC')->get();
        $posts->load('user');
        $posts->load('cates');
        return view('client.pages.post-category',['cates'=>$cates,'posts'=>$posts]);
    }

    public function create(){
        $cates = PostShareCategory::all();
        return view('client.pages.addnew-post',['cates'=>$cates]);
    }

    public function store(Request $request){
        $model = new PostShare();
        $model->title = $request->title;
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->title, '-');
        $model->content = $request->content;
        $model->user_id = Auth::user()->id;
        if($model->user_id == 1 || $model->user_id == 2 || $model->user_id == 3) $model->status = 1;
        else $model->status = 0;
        $model->save();
        return back()->width('message','Tạo mới thành công');
    }

    public function detail($slug){
        $model = PostShare::where('slug',$slug)->first();
        $cates = PostShareCategory::all();
        $model->load('cates','user','postFiles');
        $totalViews = PostView::where('post_id', $model->id)->sum('views');
        if(!$model) return back();
        return view('client.pages.post-detail',['post'=>$model,'cates'=>$cates,'totalViews'=>$totalViews]);
    }

    public function myPost($id){
        $user = Auth::user();
        $posts = PostShare::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(10);
        return view('client.pages.my-posts',['user'=>$user,'posts'=>$posts]);
    }

    public function destroy($id){
        $model = PostShare::find($id);
        if(!$model) return back();
        
        $model->delete();
        return back()->with('message','Xóa bài viết thành công !');
    }

    public function updateView(Request $request){
        // 1 kiểm tra xem có views của sản phẩm đang cần tìm trong ngày hôm nay không ?
        // nếu có thì tăng view
        // nếu không có thì tạo mới và add views = 1
        $today = Carbon::today()->format('Y-m-d');
        $postView = PostView::where('post_id', $request->id)
                                ->where('created_at', '>=', $today . " 00:00:00")
                                ->where('created_at', '<=', $today . " 23:59:59")
                                ->first();
        if($postView){
            $postView->views += 1;
        }else{
            $postView = new PostView();
            $postView->post_id = $request->id;
            $postView->views = 1;
        }
        $postView->save();
        return response()->json($postView);
    }
}
