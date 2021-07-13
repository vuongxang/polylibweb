<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::sortable()->where('role_id',1)->orWhere('role_id',2)->paginate(5);
        $users->load('role');
        return view('admin.users.index',['users'=>$users]);
    }

    public function ListClient(){
        $users = User::sortable()->where('role_id',3)->orWhere('role_id',4)->paginate(5);
        $users->load('role');
        return view('admin.users.client-list',['users'=>$users]);
    }
}
