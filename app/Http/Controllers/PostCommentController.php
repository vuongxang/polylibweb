<?php

namespace App\Http\Controllers;

use App\Events\NewNotificationEvent;
use App\Models\PostComment;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class PostCommentController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $pagesize = 10;
        if ($request->page_size) $pagesize = $request->page_size;

        $comments_approved = PostComment::sortable()->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->where('body', 'like', '%' . $keyword . '%')->paginate($pagesize);
        $comments_pending = PostComment::sortable()->where('status', 0)
            ->orderBy('created_at', 'DESC')
            ->where('body', 'like', '%' . $keyword . '%')->paginate($pagesize);
        $comments_deleted = PostComment::onlyTrashed()
            ->where('body', 'like', '%' . $keyword . '%')->paginate($pagesize);
        return view('admin.post-comments.index', [
            'comments_approved' => $comments_approved,
            'comments_pending'  => $comments_pending,
            'comments_deleted'  => $comments_deleted,
            'pagesize'          => $pagesize
        ]);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'body' => 'required',
        ]);
        
        $model = new PostComment();
        $model->fill($request->all());
        $model->status = 0;
        $model->user_id = auth()->user()->id;

        $model->save();
        $model->load(['post', 'user']);


        // Lấy ra danh sách admin-user để gửi thông báo
        $users = User::where('role_id', 1)->orWhere('role_id', 2)->get();
        // Nội dung của thông báo
        $data = [
            'avatar'    => $model->user->avatar,
            'title'     => 'Bình luận mới',
            'content'   => $model->user->name . " đã bình luận về  bài viết " . $model->post->title,
            'post_id'   => $model->post->id,
        ];
        
        foreach ($users as $key => $user) {
            $user->notify(new CommentNotification($data));
            
            $newNotify = $user->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify,$user));
        }
        // $pusher->trigger('NotificationEvent', 'send-message', $data);

        $authUser = Auth::user();
        
        if (Auth::user()->role->id != 1 && Auth::user()->role->id != 2) {
            $data1 = [
                'avatar'    => $authUser->avatar,
                'title'     => 'Bình luận của bạn đang được chờ duyệt',
                'content'   =>  "Bình luận của bạn về bài viết " . $model->post->title . " đang được chờ duyệt.",
                'post_id'   => $model->post->id
            ];
            $authUser->notify(new CommentNotification($data1));
            $newNotify = $authUser->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify,$authUser));
        }

        return back();
    }

    public function commentApprov($id)
    {

        $comment = PostComment::find($id);

        $user = User::where('id', $comment->user_id)->first();
        $comment->load('post');
        if(! $comment->post) return back()->with('message', 'Bạn không thể duyệt bình luận này !')
                                            ->with('alert-class', 'alert-danger');
        $data = [
            'avatar'    => $user->avatar,
            'title'     => 'Bình luận đã được duyệt',
            'content'   => "Bình luận của bạn về bài viết " . $comment->post->title . " đã được duyệt",
            'post_id'   => $comment->post->id
        ];

        

        if (!$comment) return back();
        $comment->status = 1;
        $comment->save();
        $user->notify(new InvoicePaid($data));
        $newNotify = $user->notifications->sortByDesc('created_at')->first();
        event(new NewNotificationEvent($newNotify,$user));
        return redirect(route('postComment.index'))->with('message', 'Xét duyệt bình luận thành công')
            ->with('alert-class', 'alert-success');
    }

    public function destroy($id)
    {
        $model = PostComment::find($id);
        if ($model) {
            $user = User::where('id', $model->user_id)->first();
            if($model->post && $model->user){
                $data = [
                    'avatar'    => $user->avatar,
                    'title'     => 'Hủy bình luận',
                    'content'   => "Bình luận của bạn về bài viết " . $model->post->title . " đã bị xóa",
                    'post_id'   => $model->post->id
                ];
    
               
                $user->notify(new InvoicePaid($data));
                $newNotify = $user->notifications->sortByDesc('created_at')->first();
                event(new NewNotificationEvent($newNotify,$user));
            }
            
            PostComment::destroy($id);

            return redirect(route('postComment.index'))->with('message', 'Chuyển vào thùng rác thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return redirect(route('postComment.index'))->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }

    public function restore($id)
    {
        PostComment::withTrashed()->where('id', $id)->restore();
        return redirect(route('postComment.index'))->with('message', 'Khôi phục thành công')
            ->with('alert-class', 'alert-success');
    }

    public function forceDelete($id)
    {

        $model = PostComment::withTrashed()->find($id);
        if ($model) {
            $user = User::where('id', $model->user_id)->first();
            if($model->post && $model->user){
                $data = [
                    'avatar'    => $user->avatar,
                    'title'     => 'Xoá bình luận',
                    'content'   => "Bình luận của bạn về bài viết " . $model->post->title . " đã bị xóa",
                    'post_id'   => $model->post->id
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
                $user->notify(new InvoicePaid($data));
            }
            
            $model = PostComment::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('postComment.index'))->with('message', 'Xóa bình luận thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return redirect(route('postComment.index'))->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }
}
