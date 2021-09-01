<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TopBorrowBookExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $keyword = "";
        $total_day = 365;

        $now = Carbon::now();
        $time_report = $now->subDay($total_day);
        $book_borrow_weeks = DB::table('books')
                        ->join('orders', 'books.id', '=', 'orders.book_id')
                        ->select('books.*', DB::raw('count(*) as total'))
                        ->where('orders.created_at','>=',$time_report->format('Y-m-d'). " 00:00:00")
                        ->where('books.title','like','%'.$keyword.'%')
                        ->groupBy('books.id' ,'books.title','books.status','books.description','books.publish_date_from','books.image','books.slug','books.created_at','books.deleted_at','books.updated_at')
                        ->orderBy('total','DESC')->get();
        return $book_borrow_weeks;
    }
    
}
