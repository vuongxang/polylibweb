<?php

namespace App\Http\Controllers;

use App\Exports\TopBorrowBookExport;
use App\Exports\TopCatePostExport;
use App\Exports\TopUserPostExport;
use App\Exports\TopViewPostExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function TopBorrowBook(Request $request){
        $pagesize = 10;
        $total_day = 7;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;
        if ($request->total_day) $total_day = $request->total_day;
        $now = Carbon::now();
        $time_report = $now->subDay($total_day);

        $book_borrow_weeks = DB::table('books')
                        ->join('orders', 'books.id', '=', 'orders.book_id')
                        ->select('books.*', DB::raw('count(*) as total'))
                        ->where('orders.created_at','>=',$time_report->format('Y-m-d'). " 00:00:00")
                        ->where('books.title','like','%'.$keyword.'%')
                        ->groupBy('books.id' ,'books.title','books.status','books.description','books.publish_date_from','books.image','books.slug','books.created_at','books.deleted_at','books.updated_at')
                        ->orderBy('total','DESC')
                        ->take($pagesize)->get();

        // dd($book_borrow_weeks);
        
        return view('admin.reports.top-borrow-book',[
                                                       'book_borrow_weeks'  => $book_borrow_weeks,
                                                       'pagesize'           => $pagesize,
                                                       'total_day'          => $total_day
                                                    ]);
    }

    public function exportTopBorrowBook(){
        return Excel::download(new TopBorrowBookExport, 'book-borrow.xlsx');
    }

    public function TopViewPost(Request $request){
        $pagesize = 10;
        $total_day = 7;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;
        if ($request->total_day) $total_day = $request->total_day;
        $now = Carbon::now();
        $time_report = $now->subDay($total_day);

        $post_views = DB::table('post_shares')
                        ->join('post_views', 'post_shares.id', '=', 'post_views.post_id')
                        ->join('users', 'post_shares.user_id', '=', 'users.id')
                        ->select('post_shares.*','users.name as user_name', DB::raw('sum(post_views.views) as total_view'))
                        ->where('post_views.created_at','>=',$time_report->format('Y-m-d'). " 00:00:00")
                        ->where('post_shares.title','like','%'.$keyword.'%')
                        ->groupBy('post_shares.id' ,'post_shares.title','post_shares.status',
                                'post_shares.content','post_shares.thumbnail','post_shares.user_id',
                                'post_shares.slug','post_shares.created_at','post_shares.deleted_at',
                                'post_shares.updated_at','user_name')
                        ->orderBy('total_view','DESC')
                        ->take($pagesize)->get();

        // dd($post_views);
        return view('admin.reports.top-post-view',[
            'post_views'  => $post_views,
            'pagesize'           => $pagesize,
            'total_day'          => $total_day
         ]);
    }
    public function exportTopViewPost(){
        return Excel::download(new TopViewPostExport, 'top-view-post.xlsx');
    }

    public function TopUserPost(Request $request){
        $pagesize = 10;
        $total_day = 7;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;
        if ($request->total_day) $total_day = $request->total_day;
        $now = Carbon::now();
        $time_report = $now->subDay($total_day);

        $user_post = DB::table('users')
                        ->join('post_shares', 'users.id', '=', 'post_shares.user_id')
                        ->select('users.id' ,'users.name','users.phone','users.birth_date',
                        'users.gender','users.google_id','users.avatar','users.email',
                        'users.role_id',DB::raw('count(*) as total'))
                        ->where('users.role_id','=',4)
                        ->where('post_shares.created_at','>=',$time_report->format('Y-m-d'). " 00:00:00")
                        ->where('users.name','like','%'.$keyword.'%')
                        ->groupBy('users.id' ,'users.name','users.email','users.phone','users.birth_date',
                                'users.gender','users.google_id','users.avatar','users.role_id')
                        ->orderBy('total','DESC')
                        ->take($pagesize)->get();

        // dd($user_post);
        return view('admin.reports.top-user-post',[
            'user_post'         => $user_post,
            'pagesize'           => $pagesize,
            'total_day'          => $total_day
         ]);
    }

    public function exportTopUserPost(){
        return Excel::download(new TopUserPostExport, 'top-user-post.xlsx');
    }

    public function TopCatePost(Request $request){
        $pagesize = 10;
        $total_day = 7;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;
        if ($request->total_day) $total_day = $request->total_day;
        $now = Carbon::now();
        $time_report = $now->subDay($total_day);

        $cate_posts = DB::table('post_share_categories')
                        ->join('post_share_category_details', 'post_share_categories.id', '=', 'post_share_category_details.cate_id')
                        ->join('post_shares','post_share_category_details.post_id', '=', 'post_shares.id')
                        ->select('post_share_categories.*', DB::raw('count(*) as total'))
                        ->where('post_shares.created_at','>=',$time_report->format('Y-m-d'). " 00:00:00")
                        ->where('post_share_categories.name','like','%'.$keyword.'%')
                        ->groupBy('post_share_categories.id' ,'post_share_categories.name',
                                'post_share_categories.slug','post_share_categories.status',
                                'post_share_categories.image','post_share_categories.description',
                                'post_share_categories.deleted_at','post_share_categories.created_at',
                                'post_share_categories.updated_at')
                        ->orderBy('total','DESC')
                        ->take($pagesize)->get();
        // dd($user_post);
        return view('admin.reports.top-cate-post',[
            'cate_posts'         => $cate_posts,
            'pagesize'           => $pagesize,
            'total_day'          => $total_day
         ]);
    }
    
    public function exportTopCatePost(){
        return Excel::download(new TopCatePostExport, 'top-cate-post.xlsx');
    }
}
