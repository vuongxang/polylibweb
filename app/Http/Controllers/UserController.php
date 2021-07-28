<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::sortable()->where('role_id',1)->orWhere('role_id',2)->paginate(5);
        $users->load('role');

        $users_locked = User::onlyTrashed()->paginate(5);
        // dd($users_locked); die;
        return view('admin.users.index',['users'=>$users,'users_locked'=>$users_locked]);
    }

    public function ListClient(){
        $users = User::sortable()->where('role_id',3)->orWhere('role_id',4)->paginate(5);
        $users->load('role');

        $users_locked = User::onlyTrashed()->paginate(5);

        return view('admin.users.client-list',['users'=>$users,'users_locked'=>$users_locked]);
    }

    public function destroy($id){
        $model = User::find($id);
        if($model){
            User::where('id',$id)->delete();
            return back()->with('message','Khóa tài khoản thành công !')
                                                    ->with('alert-class','alert-success');
        }else{
            return back()->with('message','Dữ liệu không tồn tại !')
                                                    ->with('alert-class','alert-danger');
        }
    }

    public function restore($id){
        User::withTrashed()->where('id', $id)->restore();
        return back()->with('message','Khôi phục thành công')
                                                    ->with('alert-class','alert-success');
    }

    public function forceDelete($id){
      
        $model = User::withTrashed()->find($id);
        if($model){
            $model = User::withTrashed()->where('id', $id)->forceDelete();
            return back()->with('message','Xóa tài khoản thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return back()->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }

    public function profile($id){
        $user = Auth::user();
        return view('admin.users.profile',['user'=>$user]);
    }

    public function updateProfile(Request $request,$id){
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        return back()->with('message','Cập nhật thành công !');
    }

    public function create(){
        return view('admin.users.create');
    }

    public function store(UserRequest $request){
        $model = User::where('email',$request->email)->first();
        if($model) return back();
        $model = new User();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->role_id = 2;
        $model->password = Hash::make($request->password);
        $model->save();

        return redirect(route('user.create'))->with('message','Tạo tài khoản thành công');
    }
}
