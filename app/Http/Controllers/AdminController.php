<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        $books          = Book::all();
        $categories     = Category::all();
        $authors        = Author::all();
        $comments_pending       = Comment::where('status',0)->get();
        return view('admin.dashboard',[
                'books'         => $books,
                'categories'    => $categories,
                'authors'        => $authors,
                'comments_pending'      => $comments_pending
        ]);
    }

    // public function dayData(){
        
    //     return response()->json($arrDayNames);
    // }

    public function ordersData(){
        $arrDayNames = [];
        for($i=0;$i<7;$i++){
            $now = Carbon::now();
            $arrDay[$i] = $now->subDay($i);
            $arrDayNames[$i] = $arrDay[$i]->format('D');
        }

        $arrDay=[];
        for($i=0;$i<7;$i++){
            $now = Carbon::now();
            $arrDay[$i] = $now->subDay($i);
        }

        $arrOrderDatas = [];
        foreach($arrDay as $key=> $item){
            $model = Order::where('created_at', '>=', $item->format('Y-m-d'). " 00:00:00")
                                ->where('created_at', '<=', $item->format('Y-m-d'). " 23:59:59")
                                ->count();
            $arrOrderDatas[$key] = $model;
        }

        $data['label'] =   $arrDayNames;
        $data['data'] =   $arrOrderDatas;
        return response()->json($data);
    }

    public function ordersDataMonth(){
        $arrMonthNames = [];
        for($i=0;$i<12;$i++){
            $now = Carbon::now();
            $arrMonthNames[$i] = $now->subMonth($i);
            $arrMonthNames[$i] = $arrMonthNames[$i]->format('M');
        }

        $arrDay=[];
        for($i=0;$i<12;$i++){
            $month = Carbon::now()->subMonth($i)->format('m');
            $arrDay[$i] = $month;
        }

        $arrOrderDatas = [];
        foreach($arrDay as $key=> $item){
            $model = Order::withTrashed()
                            ->whereMonth('created_at', '=', $item)
                            ->count();
            $arrOrderDatas[$key] = $model;
        }
        // $arrOrderDatas = [100,200,300,200,400,500,400,600,700,600,800,700,900];
        $data['label'] =   $arrMonthNames;
        $data['data'] =   $arrOrderDatas;
        return response()->json($data);
    }

    public function fileManager(){
        return view('admin.file-manager');
    }
}
