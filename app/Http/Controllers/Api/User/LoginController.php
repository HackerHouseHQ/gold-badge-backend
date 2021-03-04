<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;

use Carbon\Carbon;
use App\UserOtpLogin;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * send otp to mail .
     *
     * @return Json
     * @author Ratnesh Kumar
     *
     */
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
    /**
     * verify otp .
     *
     * @return Json
     * @author Ratnesh Kumar
     *
     */
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

    /**
     * change notification status .
     *
     * @return Json
     * @author Ratnesh Kumar
     *
     */
    public function change_notification_status(Request $request)
    {
        try {
            //get user notification status
            Log::info($request->all());
            $user = User::whereId(Auth::user()->id)->first();
            $user_notification_status = $request->notification_status;
            //update user notification status
            $update = User::whereId(Auth::user()->id)->update(['notification_status' => $user_notification_status]);
            return res_success(trans('messages.notificationStatus'));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        // $response = ['message' => 'You have been successfully logged out!'];
        // return response($response, 404);
        return res_success('You have been successfully logged out!');
    }
}
