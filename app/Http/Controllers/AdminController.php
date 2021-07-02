<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        // dd(Auth::user()->name);
        return view('admin.dashboard');
    }

    public function fileManager(){
        return view('admin.file-manager');
    }
}
