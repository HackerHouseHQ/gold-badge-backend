<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use Carbon\Carbon;

use App\UserOtpLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function sendOtpToMail(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [

                    'email' => 'required|email'
                ]
            );
            /**
             * Check input parameter validation
             */

            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }
            $email = $request->email;
            $updateOtp = 0;
            $checkEmailExistence = UserOtpLogin::where('email', $request->email)->first();
            if ($checkEmailExistence) {
                $otp = rand(1000, 9999);
                $updateOtp  = UserOtpLogin::where('email', $request->email)->update(['otp' => $otp, 'created_at' => Carbon::now(), 'status' => 0]);
            } else {
                $otp = rand(1000, 9999);
                $insertArray = ['email' => $request->email, 'otp' => $otp];
                $createOtp  = UserOtpLogin::create($insertArray);
            }
            $data = array("body" => "OTP Verification", 'otp' => $otp);
            $send = Mail::send('send_mail', $data, function ($message) use ($email) {
                $message->to($email)->subject('OTP Verification');
            });
            if ($updateOtp || $createOtp) {
                return res_success('Otp has been sent to your mail successfully');
            }
            return res_failed('try again.');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [

                    'email' => 'required|email',
                    'otp' => 'required'
                ]
            );
            /**
             * Check input parameter validation
             */

            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }
            $email = $request->email;
            $checkEmailExistence = UserOtpLogin::where('email', $request->email)->first();
            $otp = $request->otp;
            if ($checkEmailExistence->status == 0) {
                $differnece = $checkEmailExistence->created_at->diffInMinutes(Carbon::now());
                if ($checkEmailExistence->otp == $otp) {
                    if ($differnece  > 5) {
                        return res_success('Otp expired');
                    } else {
                        $checkEmailExistence->status = 1;
                        $checkEmailExistence->save();
                        return res_success('Otp matched successfully.');
                    }
                } else {
                    return res(402, 'Otp does not match');
                }
            }
            if ($checkEmailExistence->status == 1) {
                return res(410, 'Otp is already verified.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
