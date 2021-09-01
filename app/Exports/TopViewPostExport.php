<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TopViewPostExport implements FromCollection
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
                        ->get();
        return $post_views;
    }
    
}
