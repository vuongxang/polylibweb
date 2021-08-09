<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\Demo;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class CommentController extends Controller
{
    public function index(Request $request){
        $keyword = $request->keyword;
        $pagesize = 5;
        if($request->page_size) $pagesize = $request->page_size;

        $comments_approved = Comment::sortable()->where('status',1)
                                    ->orderBy('created_at','DESC')
                                    ->where('body','like','%'.$keyword.'%')->paginate($pagesize);
        $comments_pending = Comment::sortable()->where('status',0)
                                    ->orderBy('created_at','DESC')
                                    ->where('body','like','%'.$keyword.'%')->paginate($pagesize);
        $comments_deleted = Comment::onlyTrashed()
                                    ->where('body','like','%'.$keyword.'%')->paginate($pagesize);
        return view('admin.comments.index',[
                                            'comments_approved' => $comments_approved,
                                            'comments_pending'  => $comments_pending,
                                            'comments_deleted'  => $comments_deleted,
                                            'pagesize'          => $pagesize
                                        ]);
    }

    public function store(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);
   
        $model = new Comment();
        $model->fill($request->all());
        $model->status = 0;
        $model->user_id= auth()->user()->id;
    
        $model->save();
        $model->load(['book','user']);

        $users = User::where('role_id',1)->orWhere('role_id',2)->get();
        
        $data = [
            'title'     => 'Bình luận mới',
            'content'   => $model->user->name." Đã bình luận về sách <a href=".route('book.detail',$model->book->id).">" .$model->book->title."</a>",
            'icon-class'=> 'icon-circle',
            'book_id'   => $model->book->id
        ];

        // $options = array(
        //     'cluster' => 'ap1',
        //     'encrypted' => true
        // );

        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     $options
        // );

        // $pusher->trigger('NotificationEvent', 'send-message', $data);
        foreach ($users as $key => $user) {
            $user->notify(new InvoicePaid($data)); 
        }
        
        return back();
    }

    public function commentApprov($id){

        $comment = Comment::find($id);

        $user = User::where('id',$comment->user_id)->first();
        $data = [
            'title'     => 'Duyệt bình luận',
            'content'   => "Bình luận của bạn về sách <a href=".route('book.detail',$comment->book->id).">" .$comment->book->title."</a> Đã được duyệt",
            'icon-class'=> 'icon-circle',
            'book_id'   => $comment->book->id
        ];

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     $options
        // );

        // $pusher->trigger('NotificationEvent', 'send-message', $data);
        // $user->notify(new Demo($data));

        if(!$comment) return back();
        $comment->status = 1;
        $comment->save();
        return redirect(route('comment.index'))->with('message','Xét duyệt bình luận thành công')
                                                ->with('alert-class','alert-success');
    }

    public function destroy($id){
        $model = Comment::find($id);
        if($model){
            $user = User::where('id',$model->user_id)->first();
            $data = [
                'title'     => 'Hủy bình luận',
                'content'   => "Bình luận của bạn về sách <a href=".route('book.detail',$model->book->id).">" .$model->book->title."</a> Đã bị hủy !",
                'icon-class'=> 'icon-circle',
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
            
            Comment::destroy($id);
            
            return redirect(route('comment.index'))->with('message','Chuyển vào thùng rác thành công !')
                                                ->with('alert-class','alert-success');
        }else{
            return redirect(route('comment.index'))->with('message','Dữ liệu không tồn tại !')
                                                ->with('alert-class','alert-danger');
        }
    }

    public function restore($id){
        Comment::withTrashed()->where('id', $id)->restore();
        return redirect(route('comment.index'))->with('message','Khôi phục thành công')
                                                    ->with('alert-class','alert-success');
    }

    public function forceDelete($id){
      
        $model = Comment::withTrashed()->find($id);
        if($model){
            $user = User::where('id',$model->user_id)->first();
            $data = [
                'title'     => 'Xóa bình luận',
                'content'   => "Bình luận của bạn về sách <a href=".route('book.detail',$model->book->id).">" .$model->book->title."</a> Đã bị xóa !",
                'icon-class'=> 'icon-circle',
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
            $model = Comment::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('comment.index'))->with('message','Xóa bình luận thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return redirect(route('comment.index'))->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }
}
