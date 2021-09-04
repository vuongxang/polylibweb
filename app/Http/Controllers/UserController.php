<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportExcelRequest;
use App\Http\Requests\UserRequest;
use App\Imports\UsersImport;
use App\Models\Book;
use App\Models\PostShare;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 10;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;
        $users = User::sortable()->where('email','like','%'.$keyword.'%')->whereIn('role_id', [1,2])->paginate($pagesize);
        $users->load('role');

        $users_locked = User::onlyTrashed()->paginate($pagesize);
        // dd($users_locked); die;
        return view('admin.users.index', [
                                            'users'         => $users, 
                                            'users_locked'  => $users_locked,
                                            'pagesize'      =>$pagesize
                                        ]);
    }

    public function ListClient(Request $request)
    {
        $pagesize = 10;
        $keyword = $request->keyword;

        if ($request->page_size) $pagesize = $request->page_size;

        $users = User::sortable()->where('email','like','%'.$keyword.'%')->whereIn('role_id', [3,4])->paginate($pagesize);
        $users->load('role');

        $users_locked = User::onlyTrashed()->paginate($pagesize);

        return view('admin.users.client-list', [
                                                'users'         => $users, 
                                                'users_locked'  => $users_locked,
                                                'pagesize'      => $pagesize
                                            ]);
    }

    public function destroy($id)
    {
        $model = User::find($id);
        if ($model) {
            User::where('id', $id)->delete();
            return back()->with('message', 'Khóa tài khoản thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return back()->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }

    public function restore($id)
    {
        User::withTrashed()->where('id', $id)->restore();
        return back()->with('message', 'Khôi phục thành công')
            ->with('alert-class', 'alert-success');
    }

    public function forceDelete($id)
    {

        $model = User::withTrashed()->find($id);
        if ($model) {
            $model = User::withTrashed()->where('id', $id)->forceDelete();
            return back()->with('message', 'Xóa tài khoản thành công !')
                ->with('alert-class', 'alert-success');
        } else {
            return back()->with('message', 'Dữ liệu không tồn tại !')
                ->with('alert-class', 'alert-danger');
        }
    }

    public function profile($id)
    {
        $user = Auth::user();
        return view('admin.users.profile', ['user' => $user]);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        return back()->with('message', 'Cập nhật thành công!');
    }

    public function create()
    {
        return view('admin.users.create');
    }
    public function store(UserRequest $request)
    {
        $model = User::where('email', $request->email)->first();
        if ($model) return back();
        $model = new User();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->role_id = 2;
        $model->password = Hash::make($request->password);
        $model->save();

        return redirect(route('user.create'))->with('message', 'Tạo tài khoản thành công')->with('alert-class', 'alert-success');
    }

    public function edit($id){
        $user = User::find($id);
        if(!$user) return redirect(route('user.index'))->with('message', 'Dữ liệu không tồn tại !')->with('alert-class', 'alert-danger');
        $roles = Role::all();
        return view('admin.users.edit',['user'=>$user,'roles'=>$roles]);
    }

    public function update(UserRequest $request,$id){
        $model = User::find($id);
        if(!$model) return redirect(route('user.index'))->with('message', 'Dữ liệu không tồn tại !')->with('alert-class', 'alert-danger');
        $model->fill($request->all());
        $model->role_id = $request->role_id;
        $model->save();
        return back()->with('message', 'Cập nhật thành công !')->with('alert-class', 'alert-success');
    }

    public function readeNotification($id)
    {
        $notifications = Auth::user()->notifications;
        foreach ($notifications as $key => $value) {
            if ($value->id == $id)     $notification = $value;
        }
        $notification->markAsRead();
        // dd($notification->data);
        if(isset($notification->data['book_id'])){
            $book = Book::find($notification->data['book_id']);
            return redirect(route('book.detail', $book->slug));
        }
        if(isset($notification->data['post_id'])){
            $post = PostShare::find($notification->data['post_id']);
            return redirect(route('post.detail', $post->slug));
        }
    }

    public function lockForm(){
        return view('admin.users.lock-form');
    }

    public function massLockUser(ImportExcelRequest $request){
        Excel::import(new UsersImport,$request->file('file_upload'));
             
        return back()->with('message', 'Khóa tài khoản thành công !')
                    ->with('alert-class', 'alert-success');;
    }
    public function notifications()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('client.pages.notifications',['notifications'   => $notifications]);
    }
    public function readAllNotify()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return back();
    }
}
