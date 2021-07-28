<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $ratings = Rating::paginate($pagesize);
        dd($ratings);
        return view('admin.ratings.index');
    }
}
