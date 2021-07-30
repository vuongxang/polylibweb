<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Auth;
>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1
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
<<<<<<< HEAD
=======

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

>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1
    public function create(){
        return view('admin.users.create');
    }

<<<<<<< HEAD
    public function store(Request $request){
=======
    public function store(UserRequest $request){
>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1
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
<<<<<<< HEAD
=======

    public function readeNotification($id){
        $notifications = Auth::user()->notifications;
        foreach ($notifications as $key => $value) {
            if($value->id == $id)     $notification = $value;
        }

        $notification->markAsRead();
        return back();
    }
>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1
}
