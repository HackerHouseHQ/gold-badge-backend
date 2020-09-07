<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


use App\Admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


   public function forgotPasswordPage()
    {
        return view('auth.forgot-password');
    }
    public function forgot_password(Request $request){
            $validator = Validator::make($request->all(), [
                        'email' => 'required|max:255',
                      //  'email' => 'required|email|exists:admins|max:255',
        ]);
        if ($validator->fails()) {
          
            return Redirect::back()->withErrors($validator);
        }
        $newPassword = Hash::make(Str::random(10)); 
        $data = array('name' => 'example', 'link' => $newPassword);
        $to_name =  "vinod";
        $to_email = 'rishabh.saxena@ripenapps.com';
       // $to_email = 'vinod.thalwal@ripenapps.com';
           Mail::send('email-verify-user', $data, function ($message) use ($to_name, $to_email) {
                        // 
                        $message->to($to_email, $to_name)->subject('Forgot Password');
                        $message->from('abc@gmail.com', 'Gold badge');
                    });
     
        $updatePassword = Admin::where('email', 'goldbadge@gmail.com')->update(['password' => Hash::make($newPassword)]);
      //  if ($updatePassword) {
            return redirect('forgot-password')->with('message', 'We have successfully e-mailed your password.');
        //}
    }

}
