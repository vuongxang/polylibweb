<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class BookDetailController extends Controller
{

    public function getComment(Request $request)
    {
        $book_id = $request->id;
        if ($request->book_id > 0) {
            $comments = Comment::where('book_id', $book_id)->where('parent_id', Null)->where('id', '<', $request->book_id)->where('status', 1)->orderBy('id', 'DESC')->take(3)->get();
            // $commentsChild = Comment::where('book_id', $book_id)->where('parent_id','!=',Null)->orderBy('parent_id','DESC')->get();
            if (count($comments) > 0) {
                foreach ($comments as $com) {
                    $arr[] = $com->id;
                }
                // $commentsChild = Comment::where('book_id', $book_id)->where('parent_id','!=',Null)->whereIn('parent_id',$arr)->orderBy('parent_id','DESC')->orderBy('id','ASC')->get();

                // 
                foreach ($arr as $ab) {
                    $newCommentChild[] = Comment::where('book_id', $book_id)->where('parent_id', '!=', Null)->where('parent_id', $ab)->where('status', 1)->orderBy('parent_id', 'DESC')->orderBy('id', 'ASC')->limit(3)->with('user')->get();
                }
                foreach ($newCommentChild as $b) {
                    foreach ($b as $c) {
                        $commentChilds[] = $c;
                    }
                }
                foreach ($newCommentChild as  $child) {
                    foreach ($child as $key => $c) {
                        if ($key == 2) {

                            $lastChildId[] =  $c->id;
                        }
                    }
                }
            }
        } else {
            $comments = Comment::where('book_id', $book_id)->where('parent_id', Null)->where('status', 1)->orderBy('id', 'DESC')->take(3)->get();
            if (count($comments) > 0) {
                foreach ($comments as $com) {
                    $arr[] = $com->id;
                }
                // $commentsChild = Comment::where('book_id', $book_id)->where('parent_id','!=',Null)->whereIn('parent_id',$arr)->orderBy('parent_id','DESC')->orderBy('id','ASC')->get();

                // 
                foreach ($arr as $ab) {
                    $newCommentChild[] = Comment::where('book_id', $book_id)->where('parent_id', '!=', Null)->where('parent_id', $ab)->where('status', 1)->orderBy('parent_id', 'DESC')->orderBy('id', 'ASC')->take(3)->with('user')->get();
                }
                foreach ($newCommentChild as $b) {
                    foreach ($b as $c) {
                        $commentChilds[] = $c;
                    }
                }
                foreach ($newCommentChild as  $child) {
                    foreach ($child as $key => $c) {
                        if ($key == 2) {

                            $lastChildId[] =  $c->id;
                        }
                    }
                }
            }
        }
        $comments->load('user');
        // $commentsChild->load('user');
        // $comments = Comment::where('book_id', $book_id)->where('parent_id', Null)->orderBy('id', 'DESC')->take(3)->get();
        if (!empty($commentChilds)) {

            return response()->json([$comments, $commentChilds]);
            // return response()->json([$comments, $commentChilds]);
        } else {
            return response()->json([$comments, $commentChilds = []]);
        }
    }

    public function getCommentChild(Request $request)
    {
        $book_id = $request->id;
        $parrentId = $request->parrentId;
        $commentId = $request->commentId;
        //Lấy được parent_id
        $commentChild = Comment::where('book_id', $book_id)->where('parent_id', '!=', Null)->where('parent_id', $parrentId)->where('id', '>', $commentId)->where('status', 1)->orderBy('parent_id', 'DESC')->orderBy('id', 'ASC')->limit(3)->with('user')->get();
        return response()->json($commentChild);
    }
    public function getRate(Request $request)
    {
        $book_id = $request->book_id;
        $last_rate_id = $request->last_rate_id;
        //Lấy được parent_id
        if($last_rate_id > 0 ){

            $rates = Rating::where('rateable_id', $book_id)->where('status', 1)->where('id',"<",$last_rate_id)->orderBy('id', 'DESC')->limit(3)->with('user')->get();
        }
        else{
            $rates = Rating::where('rateable_id', $book_id)->where('status', 1)->orderBy('id', 'DESC')->limit(3)->with('user')->get();
            if(count($rates) == 0 ){

                $message = "Chưa có đánh giá nào cho cuốn sách";
                
            }
        }
        if(!isset($message) ){

            return response()->json([$rates]);
        }
        else{
            return response()->json([$rates,$message]);

        }
    }
}