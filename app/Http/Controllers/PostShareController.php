<?php

namespace App\Http\Controllers;

use App\Events\NewNotificationEvent;
use App\Http\Requests\PostShareEditRequest;
use App\Models\PostShare;
use App\Http\Requests\PostShareRequest;
use App\Models\PostComment;
use App\Models\PostFileData;
use App\Models\PostShareCategory;
use App\Models\PostShareCategoryDetail;
use App\Models\PostView;
use App\Models\User;
use App\Models\Wishlist;
use App\Notifications\InvoicePaid;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostShareController extends Controller
{
    //admin route method
    public function index(Request $request)
    {
        $pagesize = 10;
        $keyword = $request->keyword;
        if ($request->page_size) $pagesize = $request->page_size;

        $posts = PostShare::sortable()->where('title', 'like', "%" . $keyword . "%")->where('status', 1)
            ->orderBy('created_at', 'DESC')->paginate($pagesize);
        $posts->load('user', 'cates');

        $posts_pending = PostShare::sortable()->where('title', 'like', "%" . $keyword . "%")->where('status', 0)
            ->orderBy('created_at', 'DESC')->paginate($pagesize);
        $posts_pending->load('user', 'cates');

        $posts_rejected = PostShare::sortable()->where('title', 'like', "%" . $keyword . "%")->where('status', 2)
            ->orderBy('created_at', 'DESC')->paginate($pagesize);
        $posts_rejected->load('user', 'cates');

        return view('admin.posts.index', [
            'posts'             => $posts,
            'pagesize'          => $pagesize,
            'posts_pending'     => $posts_pending,
            'posts_rejected'    => $posts_rejected
        ]);
    }

    public function postApprov($id)
    {
        $model = PostShare::find($id);
        if (!$model) return redirect(route('post.index'))->with('message', 'Dữ liệu không tồn tại !')->with('alert-class', 'alert-dangeraprov');

        $user = $model->user;

        if ($user) {
            $data = [
                'avatar'    => $user->avatar,
                'title'     => 'Bài viết được phê duyệt',
                'content'   => "Bài viết " . $model->title . "của bạn đã được duyệt",
                'post_id'   => $model->id
            ];

            $user->notify(new InvoicePaid($data));
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify, $user));
        }
        $model->status = 1;
        $model->save();
        return redirect(route('post.index'))->with('message', 'Duyệt bài viết thành công !')->with('alert-class', 'alert-success');
    }

    public function postRefuse($id)
    {
        $model = PostShare::find($id);
        if (!$model) return redirect(route('post.index'))->with('message', 'Dữ liệu không tồn tại !')->with('alert-class', 'alert-dangeraprov');

        $user = $model->user;

        if ($user) {
            $data = [
                'avatar'    => $user->avatar,
                'title'     => 'Bài viết được bị từ chối',
                'content'   => "Bài viết " . $model->title . "của bạn đã bị từ chối.Cập nhập lại bài viết để được phê duyệt lại",
                'post_id'   => $model->id
            ];

            $user->notify(new InvoicePaid($data));
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify, $user));
        }
        $model->status = 2;
        $model->save();
        return redirect(route('post.index'))->with('message', 'Bài viết đã bị từ chối duyệt !')->with('alert-class', 'alert-success');
    }

    //client method
    public function all()
    {
        Carbon::setLocale('vi');
        $cates = PostShareCategory::where('status', 1)->get();
        $cates->load('posts');
        $posts = PostShare::where('status', 1)->orderBy('created_at', 'DESC')->paginate(5);
        $posts->load('user', 'cates','comments','postViews');
        // dd($wishlist);
        // foreach ($posts as $key => $post) {
        //     if(!$post->user) dd($post->user()->withTrashed()->first()->avatar);
        // }
        // return view('client.pages.post');
        return view('client.pages.post', ['cates' => $cates, 'posts' => $posts]);
    }

    public function create()
    {
        $cates = PostShareCategory::where('status', 1)->get();
        return view('client.pages.addnew-post', ['cates' => $cates]);
    }

    public function store(PostShareRequest $request)
    {
        $model = new PostShare();
        if ($request->hasFile('thumbnail')) {
            $fileName = uniqid() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads/post-thumbnail', $fileName, 'public');
            $model->thumbnail = 'storage/' . $filePath;
        }
        $model->title = $request->title;
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->title, '-');
        $model->content = $request->content;
        $model->user_id = Auth::user()->id;
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3) $model->status = 1;
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

        if ($request->hasFile('file_upload')) {
            $file_uploads   = $request->file_upload;
            $file_titles     = $request->file_title;

            foreach ($file_uploads as $key => $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/documents', $fileName, 'public');

                $item = [
                    'url'       => 'storage/'.$filePath,
                    'title'     => $file_titles[$key],
                    'post_id'   => $model->id
                ];
                DB::table('post_file_data')->insert($item);
            }
        }

        //Gửi notification cho admin
        $model->load('user');
        $users = User::where('role_id', 1)->orWhere('role_id', 2)->get();

        foreach ($users as $key => $user) {
            $data = [
                'avatar'    => $model->user->avatar,
                'title'     => 'Bài viết mới',
                'content'   => $model->user->name . " vừa đăng một bài viết mới",
                'post_id'   => $model->id
            ];

            $user->notify(new InvoicePaid($data));
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify, $user));
        }


        return redirect(route('user.myPost', $model->user_id))->with('message', 'Tạo mới thành công');
    }
    public function uploads_ckeditor(Request $request){
        if($request->hasFile('upload')){
            $originalName = $request->file('upload')->getClientOriginalName();
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $filename.'_'.time().'.'.$extension;
            $request->file('upload')->move('uploads/post/', $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/post/'. $fileName);
            // $msg = 'Tải ảnh lên thành công';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum,'$url')</script>";
            @header('Content-type:text/html; charset=utf-8');
            echo $response;
        }
    }

    public function edit($id)
    {
        $model = PostShare::find($id);
        if (!$model) return redirect(route('user.myPost', Auth::user()->id));
        if (Auth::user()->id != $model->user_id) return redirect(route('user.myPost', Auth::user()->id));

        $model->load('user', 'cates', 'postFiles');

        $cates = PostShareCategory::all();
        return view('client.pages.edit-post', ['post' => $model, 'cates' => $cates]);
    }

    public function update(PostShareEditRequest $request,$id){

        $model = PostShare::find($id);
        if(!$model) return redirect(route('user.myPost', Auth::user()->id))->with('message', 'Dữ liệu không tồn tại');

        if ($request->hasFile('thumbnail')) {
            $fileName = uniqid() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads/post-thumbnail', $fileName, 'public');
            $model->thumbnail = 'storage/' . $filePath;
        }

        if($request->file_close){
            $file_closes = json_decode($request->file_close);
            foreach ($file_closes as $key => $id) {
                PostFileData::find($id)->delete();
            }
        }
        $model->title = $request->title;
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->title, '-');
        $model->content = $request->content;
        $model->user_id = Auth::user()->id;
        if ($model->user_id == 1 || $model->user_id == 2 || $model->user_id == 3) $model->status = 1;
        else $model->status = 0;

        $model->save();

        if ($request->cate_id) {
            PostShareCategoryDetail::where('post_id',$model->id)->delete();
            foreach ($request->cate_id as $cate_id) {
                $item = [
                    'cate_id' => $cate_id,
                    'post_id' => $model->id
                ];
                DB::table('post_share_category_details')->insert($item);
            }
        }

        if ($request->hasFile('file_upload')) {
            $file_uploads   = $request->file_upload;
            $file_titles     = $request->file_title;

            foreach ($file_uploads as $key => $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/documents', $fileName, 'public');

                $item = [
                    'url'       => 'storage/'.$filePath,
                    'title'     => $file_titles[$key],
                    'post_id'   => $model->id
                ];
                DB::table('post_file_data')->insert($item);
            }
        }
        return redirect(route('user.myPost', Auth::user()->id))->with('message', 'Cập nhật thành công');
    }

    public function detail($slug)
    {
        Carbon::setLocale('vi');
        $model = PostShare::where('slug', $slug)->first();

        $cates = PostShareCategory::all();
        $model->load('cates', 'user', 'postFiles');

        $postsOfUser = PostShare::where('user_id', $model->user()->withTrashed()->first()->id)->where('id', '!=', $model->id)->where('status', 1)->get();
        $postsOfUser->load('cates', 'user', 'postFiles');
        $wishlist = Wishlist::where('post_id', $model->id)->where('user_id', Auth::user()->id)
            ->where('status', 'Đã thêm')->first();
        $totalViews = PostView::where('post_id', $model->id)->sum('views');
        $comments = PostComment::where('post_id', $model->id)->where('status',1)->orderBy('id', 'DESC')->paginate(10);
        if (!$model) return back();
        
        return view('client.pages.post-detail', [
                                                    'post'          => $model, 
                                                    'cates'         => $cates, 
                                                    'totalViews'    => $totalViews, 
                                                    'postsOfUser'   => $postsOfUser, 
                                                    'wishlist'      => $wishlist,
                                                    'comments'      => $comments
                                                ]);
    }

    public function myPost($id)
    {
        $user = Auth::user();
        $wishlists = Wishlist::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(10);
        $posts = PostShare::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('client.pages.my-posts', ['user' => $user, 'posts' => $posts, 'wishlists' => $wishlists]);
    }

    public function destroy($id)
    {
        $model = PostShare::find($id);
        
        if (!$model) return back();
        Wishlist::where('post_id', $id)->delete();
        $model->delete();
        return back()->with('message', 'Xóa bài viết thành công !');
    }

    public function updateView(Request $request)
    {
        // 1 kiểm tra xem có views của sản phẩm đang cần tìm trong ngày hôm nay không ?
        // nếu có thì tăng view
        // nếu không có thì tạo mới và add views = 1
        $today = Carbon::today()->format('Y-m-d');
        $postView = PostView::where('post_id', $request->id)
            ->where('created_at', '>=', $today . " 00:00:00")
            ->where('created_at', '<=', $today . " 23:59:59")
            ->first();
        if ($postView) {
            $postView->views += 1;
        } else {
            $postView = new PostView();
            $postView->post_id = $request->id;
            $postView->views = 1;
        }
        $postView->save();
        return response()->json($postView);
    }

    public function getPostsByCategory($slug)
    {
        Carbon::setLocale('vi');
        $checkSlug = PostShareCategory::where('slug', $slug)->where('status', 1)->first();

        if (!$checkSlug) {
            return abort(404);
        }

        $posts = PostShare::whereHas('cates', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->where('status', 1)->paginate(5);

        $cates = PostShareCategory::where('status', 1)->get();
        $cates->load('posts');
        if (count($posts) > 0) {
            return view('client.pages.post')->with(['cates' => $cates, 'posts' => $posts])->with('message', 'Có ' . count($posts) . ' bài viết thuộc danh mục ' . $checkSlug->name);
        } else {
            return view('client.pages.post')->with(['cates' => $cates, 'posts' => $posts])->with('message', 'Danh mục ' . $checkSlug->name . ' chưa có bài viết nào');
        }
    }
    public function postUser($id)
    {   
        $user = User::where('id',$id)->withTrashed()->first();
        $user->load('wishlist');
        if(!$user){return abort(404);}
        $posts = PostShare::where('user_id',$user->id)->paginate(5);



        return view('client.pages.post-user')->with(['posts' => $posts,'user' => $user]);
    }
}
