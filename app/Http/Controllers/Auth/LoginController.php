<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        // $user->emai = 'vuonglq@fe.edu.vn';
        $pattentEmailFpt = "/[A-Za-z0-9_]@fpt.edu.vn/";
        $pattentEmailFe = "/[A-Za-z0-9_]@fe.edu.vn/";
        if( !preg_match($pattentEmailFpt, $user->email)){
            return redirect(route('login'))->with('message','Vui lòng đăng nhập mail fpt.edu.vn');
        }
        
        $check_locked = $this->_registerOrLoginUser($user);

        // var_dump($check_locked); die;

        if(!$check_locked) return redirect(route('login'))->with('message','Tài khoản đã bị khóa');
        // Return home after login
        else return redirect()->route('home');
    }
    protected function _registerOrLoginUser($data)
    {
        $pattentStudentEmail = "/[a-z][a-z]{2,3}[0-9]{5}@fpt.edu.vn/";

        $user = User::where('email', '=', $data->email)->first();

        $user_locked = User::onlyTrashed()->where('email', '=', $data->email)->first();

        if($user_locked) {
            return false;
        }

        if (!$user) {
           if( preg_match($pattentStudentEmail, $data->email)){
               $role_id = 4;
           }else{
               $role_id = 3;
           }

            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->google_id = $data->id;
            $user->avatar = $data->avatar;
            $user->role_id = $role_id;
            $user->password =  Hash::make('123456');
            $user->save();
        }
        Auth::login($user);
    }

    public function loginForm(){
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request){
        // thực hiện validate bằng $request
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => "Hãy nhập địa chỉ email.",
                'email.email' => "Không đúng định dạng email.",
                'password.required' => "Hãy nhập mật khẩu."
            ]
        );
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->role_id == 4 || Auth::user()->role_id==3) {
                Auth::logout();
                return redirect(route('adminLoginForm'))->with('error', "Bạn không có quyền truy cập.");
            };
            return redirect(route('dashboard'));
        }

        return redirect()->back()->with('error', "Sai thông tin đăng nhập");
    }

}
