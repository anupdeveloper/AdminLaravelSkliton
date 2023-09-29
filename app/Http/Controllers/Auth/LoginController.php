<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;
use Hash;

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
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginForm()
    {
        $pageTitle = 'Login';
        $pageDescription = 'Login Page';
        return view('auth.login', compact('pageTitle', 'pageDescription'));
    }

   
    public function login(Request $request) {
        $this->validate($request,['email' => 'required|email','password' => 'required']);
    
        $email = request()->email;
        $password = request()->password;
        $credentials = array('email' => $email , 'password' => $password);
        $attempt = Auth::attempt($credentials);
        if ($attempt) {
            // Authentication passed...
            return redirect()->route('admin.user.index');
        } else {
            //dd($credentials);
            return redirect()->back()->withErrors(['msg' => trans('login.login_page.These_credentials_do_not_match_our_records')]);
        } 
       
    }

    public function logout(Request $request) {

        Auth::logout();
        Session::flush();
        return redirect()->route('login');;
    }
}
