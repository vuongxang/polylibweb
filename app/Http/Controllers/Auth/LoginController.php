<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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

        $check_locked = $this->_registerOrLoginUser($user);

        // var_dump($check_locked); die;

        if(!$check_locked) return redirect(route('login'))->with('message','Tài khoản của bạn đã bị khóa,vui lòng liên hệ quản trị viên để được hỗ trợ !');
        // Return home after login
        else return redirect()->route('home');
    }
    protected function _registerOrLoginUser($data)
    {
        $pattentStudentEmail = "/[a-z]ph[0-9]{5}@fpt.edu.vn/";

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

}
