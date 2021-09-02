<?php

namespace App\Http\Controllers;

use App\Events\NewNotificationEvent;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class BookDetailController extends Controller
{

    public function getComment(Request $request)
    {
        $book_slug = $request->id;
        $book = Book::where('slug', $book_slug)->first();
        if ($request->book_id > 0) {
            $comments = Comment::where('book_id', $book->id)->where('parent_id', Null)->where('id', '<', $request->book_id)->where('status',1)->orderBy('id', 'DESC')->take(3)->get();
            // $commentsChild = Comment::where('book_id', $book_id)->where('parent_id','!=',Null)->orderBy('parent_id','DESC')->get();
            if (count($comments) > 0) {
                foreach ($comments as $com) {
                    $arr[] = $com->id;
                }
                // $commentsChild = Comment::where('book_id', $book_id)->where('parent_id','!=',Null)->whereIn('parent_id',$arr)->orderBy('parent_id','DESC')->orderBy('id','ASC')->get();

                // 
                foreach ($arr as $ab) {
                    $newCommentChild[] = Comment::where('book_id', $book->id)->where('parent_id', '!=', Null)->where('parent_id', $ab)->where('status', 1)->orderBy('parent_id', 'DESC')->orderBy('id', 'ASC')->limit(3)->with('user')->get();
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
            $comments = Comment::where('book_id', $book->id)->where('parent_id', Null)->where('status', 1)->orderBy('id', 'DESC')->take(3)->get();
            if (count($comments) > 0) {
                foreach ($comments as $com) {
                    $arr[] = $com->id;
                }
                // $commentsChild = Comment::where('book_id', $book_id)->where('parent_id','!=',Null)->whereIn('parent_id',$arr)->orderBy('parent_id','DESC')->orderBy('id','ASC')->get();

                // 
                foreach ($arr as $ab) {
                    $newCommentChild[] = Comment::where('book_id', $book->id)->where('parent_id', '!=', Null)->where('parent_id', $ab)->where('status', 1)->orderBy('parent_id', 'DESC')->orderBy('id', 'ASC')->take(3)->with('user')->get();
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
        // $comments->load('user');
        $comments->load([
            'user' => function ($query) {
                $query->withTrashed();
            },
        ]);

        // $comments->user()->withTrashed()->get();
        // $commentsChild->load('user');
        // $comments = Comment::where('book_id', $book_id)->where('parent_id', Null)->orderBy('id', 'DESC')->take(3)->get();
        if (!empty($commentChilds)) {

            return response()->json([$comments, $commentChilds, $book->id]);
            // return response()->json([$comments, $commentChilds]);
        } else {
            return response()->json([$comments, $commentChilds = [], $book->id]);
        }
    }

    public function getCommentChild(Request $request)
    {
        $book_slug = $request->id;
        $book = Book::where('slug', $book_slug)->first();
        $parrentId = $request->parrentId;
        $commentId = $request->commentId;
        //Lấy được parent_id
        $commentChild = Comment::where('book_id', $book->id)->where('parent_id', '!=', Null)->where('parent_id', $parrentId)->where('id', '>', $commentId)->orderBy('parent_id', 'DESC')->orderBy('id', 'ASC')->limit(3)->with('user')->get();
        $commentChild->load([
            'user' => function ($query) {
                $query->withTrashed();
            },
        ]);
        // $commentChild->user()->withTrashed()->get();
        return response()->json($commentChild);
    }


    public function storeComment(Request $request)
    {

        $book_slug = $request->book_id;
        $book = Book::where('slug', $book_slug)->first();
        if (!$book) {
            return response()->json($book_slug);
        }
        $model = new Comment();
        $model->body = $request->body;
        $model->parent_id = $request->parent_id;
        $model->book_id = $book->id;
        $model->status = 0;
        $model->user_id = Auth::user()->id;

        $model->save();

        return response()->json('Thành công');
    }
    public function getRate(Request $request)
    {
        $book_slug = $request->book_id;
        $last_rate_id = $request->last_rate_id;
        //Lấy được parent_id

        $book = Book::where('slug', $book_slug)->where('status', 1)->first();

        if ($last_rate_id > 0) {

            $rates = Rating::where('rateable_id', $book->id)->where('status', 1)->where('id', "<", $last_rate_id)->orderBy('id', 'DESC')->limit(3)->with('user')->get();
        } else {
            $rates = Rating::where('rateable_id', $book->id)->where('status', 1)->orderBy('id', 'DESC')->limit(3)->with('user')->get();
            if (count($rates) == 0) {

                $message = "Chưa có đánh giá nào cho cuốn sách";
            }
        }
        $rates->load(['user' => function ($query) {
            $query->withTrashed();
        }]);
        if (!isset($message)) {

            return response()->json([$rates]);
        } else {
            return response()->json([$rates, $message]);
        }
    }
}
