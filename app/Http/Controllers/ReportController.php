<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
