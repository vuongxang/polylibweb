<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class TopUserPostExport implements FromCollection
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
                        ->get();

        return $user_post;
    }
    
}
