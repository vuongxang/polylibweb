<?php

namespace App\Http\Controllers;

use App\Events\NewNotificationEvent;
use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentNotification;
use App\Notifications\Demo;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $pagesize = 10;
        if ($request->page_size) $pagesize = $request->page_size;

        $comments_approved = Comment::sortable()->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->where('body', 'like', '%' . $keyword . '%')->paginate($pagesize);
        $comments_pending = Comment::sortable()->where('status', 0)
            ->orderBy('created_at', 'DESC')
            ->where('body', 'like', '%' . $keyword . '%')->paginate($pagesize);
        $comments_deleted = Comment::onlyTrashed()
            ->where('body', 'like', '%' . $keyword . '%')->paginate($pagesize);
        return view('admin.comments.index', [
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
        
        $model = new Comment();
        $model->fill($request->all());
        $model->status = 0;
        $model->user_id = auth()->user()->id;
        $model->save();
        $model->load(['book', 'user']);


        // Lấy ra danh sách để gửi thông báo
        $users = User::where('role_id', 1)->orWhere('role_id', 2)->get();
        // Nội dung của thông báo
        $data = [
            'avatar'    => $model->user->avatar,
            'title'     => 'Bình luận mới',
            'content'   => $model->user->name . " đã bình luận về sách " . $model->book->title,
            'book_id'   => $model->book->id,
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
                'content'   =>  "Bình luận của bạn về sách " . $model->book->title . " đang được chờ duyệt.",
                'book_id'   => $model->book->id
            ];
            $authUser->notify(new CommentNotification($data1));
            $newNotify = $authUser->notifications->sortByDesc('created_at')->first();
            event(new NewNotificationEvent($newNotify,$authUser));
        }

        // Gửi thông báo cho từng user sau khi comment một cuốn sách
        return back();
    }

    public function commentApprov($id)
    {

        $comment = Comment::find($id);

        $user = User::where('id', $comment->user_id)->first();
        $comment->load('book');
        if(! $comment->book) return back()->with('message', 'Bạn không thể duyệt bình luận này !')
                                            ->with('alert-class', 'alert-danger');
        $data = [
            'avatar'    => $user->avatar,
            'title'     => 'Bình luận đã được duyệt',
            'content'   => "Bình luận của bạn về sách " . $comment->book->title . " đã được duyệt",
            'book_id'   => $comment->book->id
        ];

        

        if (!$comment) return back();
        $comment->status = 1;
        $comment->save();
        $user->notify(new InvoicePaid($data));
        $newNotify = $user->notifications->sortByDesc('created_at')->first();
        event(new NewNotificationEvent($newNotify,$user));
        return redirect(route('comment.index'))->with('message', 'Xét duyệt bình luận thành công')
            ->with('alert-class', 'alert-success');
    }

    public function destroy($id)
    {
        $model = Comment::find($id);
        if ($model) {
            $user = User::where('id', $model->user_id)->first();
            if($model->book && $model->user){
                $data = [
                    'avatar'    => $user->avatar,
                    'title'     => 'Hủy bình luận',
                    'content'   => "Bình luận của bạn về sách " . $model->book->title . " đã bị xóa",
                    'book_id'   => $model->book->id
                ];
    
               
                $user->notify(new InvoicePaid($data));
                $newNotify = $user->notifications->sortByDesc('created_at')->first();
                event(new NewNotificationEvent($newNotify,$user));
            }
            
            Comment::destroy($id);

            return redirect(route('comment.index'))->with('message', 'Chuyển vào thùng rác thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return redirect(route('comment.index'))->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }

    public function restore($id)
    {
        Comment::withTrashed()->where('id', $id)->restore();
        return redirect(route('comment.index'))->with('message', 'Khôi phục thành công')
            ->with('alert-class', 'alert-success');
    }

    public function forceDelete($id)
    {

        $model = Comment::withTrashed()->find($id);
        if ($model) {
            $user = User::where('id', $model->user_id)->first();
            if($model->book && $model->user){
                $data = [
                    'title'     => 'Xóa bình luận',
                    'content'   => "Bình luận của bạn về sách <a href=" . route('book.detail', $model->book->id) . ">" . $model->book->title . "</a> Đã bị xóa !",
                    'icon-class' => 'icon-circle',
                    'book_id'   => $model->book->id
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
            
            $model = Comment::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('comment.index'))->with('message', 'Xóa bình luận thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return redirect(route('comment.index'))->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }
}
