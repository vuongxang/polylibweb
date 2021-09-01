<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TopCatePostExport implements FromCollection
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
                        ->get();
        return $cate_posts;
    }
    
}
