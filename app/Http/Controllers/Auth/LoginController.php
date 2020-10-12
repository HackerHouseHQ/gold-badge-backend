<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
// use Session;

class LoginController extends Controller
{
    // use Authenticatable;;

    protected function guard()
    {
        // echo"sdf"; die;
        return Auth::guard('admin');
    }

    public function __construct()
    {
        // $this->middleware('adminMiddlerware');
        $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
        return view('auth/login');
    }
    public function logout(Request $request)
    {
        // echo"dsf"; die;

        $sessionKey = $this->guard()->getName();

        $this->guard()->logout();

        $request->session()->forget($sessionKey);
        return redirect()->route('login');
    }

    use AuthenticatesUsers;

    //echo"asdfghj"; die;

    protected $redirectTo = '/home'; //'/home';
}
