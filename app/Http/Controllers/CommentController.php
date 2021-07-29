<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $pagesize = 5;
        $comments_approved = Comment::sortable()->where('status',1)
                                    ->orderBy('created_at','DESC')->paginate($pagesize);
        return view('admin.comments.index',['comments_approved'=>$comments_approved]);
    }

    public function store(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);
   
        
        $input = $request->all();

        $input['user_id'] = auth()->user()->id;
    
        Comment::create($input);
   
        return back();
    }
}
