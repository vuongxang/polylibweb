<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::sortable()->paginate(5);
        $users->load('role');
        return view('admin.users.index',['users'=>$users]);
    }
}
