<?php

namespace App\Http\Controllers;

use App\Events\NewNotificationEvent;
use App\Models\PostShare;
use App\Models\PostShareCategory;
use App\Models\PostView;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostShareController extends Controller
{
    //admin route method
    public function index(Request $request){
        $pagesize = 10;
        $keyword=$request->keyword;
        if($request->page_size) $pagesize = $request->page_size;

        $posts = PostShare::sortable()->where('title','like',"%".$keyword."%")->where('status',1)
                            ->orderBy('created_at','DESC')->paginate($pagesize);
        $posts->load('user','cates');
        
        $posts_pending = PostShare::sortable()->where('title','like',"%".$keyword."%")->where('status',0)
                            ->orderBy('created_at','DESC')->paginate($pagesize);
        $posts_pending->load('user','cates');

        $posts_rejected = PostShare::sortable()->where('title','like',"%".$keyword."%")->where('status',2)
                            ->orderBy('created_at','DESC')->paginate($pagesize);
        $posts_rejected->load('user','cates');
        
        return view('admin.posts.index',[
            'posts'             => $posts,
            'pagesize'          => $pagesize,
            'posts_pending'     => $posts_pending,
            'posts_rejected'    => $posts_rejected
        ]);
    }

    public function postApprov($id){
        $model = PostShare::find($id);
        if(!$model) return redirect(route('post.index'))->with('message', 'Dữ liệu không tồn tại !')->with('alert-class', 'alert-dangeraprov');
        
        $user = $model->user;

        if($user){
            $data = [
                'avatar'    => $user->avatar,
                'title'     => 'Bài viết được phê duyệt',
                'content'   => "Bài viết " . $model->title . "của bạn đã được duyệt",
                'post_id'   => $model->id
            ];
    
            $user->notify(new InvoicePaid($data));
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify,$user));
        }
        $model->status = 1;
        $model->save();
        return redirect(route('post.index'))->with('message', 'Duyệt bài viết thành công !')->with('alert-class', 'alert-success');
    }

    public function postRefuse($id){
        $model = PostShare::find($id);
        if(!$model) return redirect(route('post.index'))->with('message', 'Dữ liệu không tồn tại !')->with('alert-class', 'alert-dangeraprov');
        
        $user = $model->user;

        if($user){
            $data = [
                'avatar'    => $user->avatar,
                'title'     => 'Bài viết được bị từ chối',
                'content'   => "Bài viết " . $model->title . "của bạn đã bị từ chối.Cập nhập lại bài viết để được phê duyệt lại",
                'post_id'   => $model->id
            ];
    
            $user->notify(new InvoicePaid($data));
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify,$user));
        }
        $model->status = 2;
        $model->save();
        return redirect(route('post.index'))->with('message', 'Bài viết đã bị từ chối duyệt !')->with('alert-class', 'alert-success');
    }

    //client method
    public function all(){
        $cates = PostShareCategory::all();
        $cates->load('posts');
        $posts = PostShare::where('status',1)->orderBy('created_at','DESC')->get();
        $posts->load('user');
        $posts->load('cates');
        // foreach ($posts as $key => $post) {
        //     if(!$post->user) dd($post->user()->withTrashed()->first()->avatar);
        // }
        return view('client.pages.post-category',['cates'=>$cates,'posts'=>$posts]);
    }

    public function create(){
        $cates = PostShareCategory::all();
        return view('client.pages.addnew-post',['cates'=>$cates]);
    }

    public function store(Request $request){
        $model = new PostShare();
        if($request->hasFile('thumbnail')){
            $fileName = uniqid().'_'.$request->file('thumbnail')->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads/post-thumbnail', $fileName, 'public');
            $model->thumbnail = 'storage/'.$filePath;

        }
        $model->title = $request->title;
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->title, '-');
        $model->content = $request->content;
        $model->user_id = Auth::user()->id;
        if($model->user_id == 1 || $model->user_id == 2 || $model->user_id == 3) $model->status = 1;
        else $model->status = 0;

        $model->save();

        if ($request->cate_id) {
            foreach ($request->cate_id as $cate_id) {
                $item = [
                    'cate_id' => $cate_id,
                    'post_id' => $model->id
                ];
                DB::table('post_share_category_details')->insert($item);
            }
        }

        if($request->hasFile('file_upload')){
            $file_uploads   = $request->file_upload;
            $file_titles     = $request->file_title;
            
            foreach ($file_uploads as $key => $file) {
                $fileName = uniqid().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/documents', $fileName, 'public');

                $item = [
                    'url'       => $fileName,
                    'title'     => $file_titles[$key],
                    'post_id'   => $model->id
                ];
                DB::table('post_file_data')->insert($item);
            }
        }

        //Gửi notification cho admin
        $model->load('user');
        $users = User::where('role_id',1)->orWhere('role_id',2)->get();
        
        foreach ($users as $key => $user) {
            $data = [
                'avatar'    => $model->user->avatar,
                'title'     => 'Bài viết mới',
                'content'   => $model->user->name." vừa đăng một bài viết mới",
                'post_id'   => $model->id
            ];
    
            $user->notify(new InvoicePaid($data));
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify,$user));
        }
            

        return redirect(route('user.myPost',$model->user_id))->with('message','Tạo mới thành công');
    }

    public function edit($id){
        $model = PostShare::find($id);
        if(!$model) return redirect(route('user.myPost',Auth::user()->id));
        if(Auth::user()->id != $model->user_id) return redirect(route('user.myPost',Auth::user()->id));

        $model->load('user','cates','postFiles');

        $cates = PostShareCategory::all();
        return view('client.pages.edit-post',['post'=>$model,'cates'=>$cates]);
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
