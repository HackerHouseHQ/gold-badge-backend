<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
    public function resetPasswordPage()
    {
        return view('auth.reset-password');
    }
    public  function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return redirect('reset-password')
                ->withErrors($validator)
                ->withInput();
        }
        $updatePassword = Admin::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        if ($updatePassword) {
            return redirect('login')->with('message', 'Your password has  been changed succesfully.');
        }
    }

    use SendsPasswordResetEmails;
}
