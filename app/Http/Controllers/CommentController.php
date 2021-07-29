<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;

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
   
        
        $input = $request->all();

        $input['user_id'] = auth()->user()->id;
    
        Comment::create($input);
        $user = User::find(auth()->user()->id);
        
        $data = [
            'title'=> 'aaaaa',
            'content' => 'demo content'
        ];

        $user->notify(new InvoicePaid($data));   
        return back();
    }

    public function commentApprov($id){
        $comment = Comment::find($id);
        if(!$comment) return back();
        $comment->status = 1;
        $comment->save();
        return redirect(route('comment.index'))->with('message','Xét duyệt bình luận thành công')
                                                ->with('alert-class','alert-success');
    }

    public function destroy($id){
        $model = Comment::find($id);
        if($model){
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
            $model = Comment::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('comment.index'))->with('message','Xóa bình luận thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return redirect(route('comment.index'))->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }
}
