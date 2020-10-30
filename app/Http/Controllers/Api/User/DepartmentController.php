<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\UserDepartmentFollow;
use App\UserDepartmentRequest;
use App\Http\Controllers\Controller;
use App\UserDepartmentBadgeFollow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    /**
     * save department request .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function saveDepartmentRequest(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $validator = Validator::make(
                $request->all(),
                [
                    'department_name' => 'required|string'
                ]
            );
            /**
             * Check input parameter validation
             */


            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }
            $checkAlredySendRequest = UserDepartmentRequest::where('country_id',  Auth::user()->country_id)
                ->where('state_id',  Auth::user()->state_id)
                ->where('city_id',  Auth::user()->city_id)
                ->where('department_name', $request->department_name)->first();
            if ($checkAlredySendRequest) {
                throw new Exception(trans('This department is already under verification.'), DATA_EXISTS);
            }
            $insertArray = [
                'user_id' => Auth::user()->id,
                'country_id' => Auth::user()->country_id,
                'state_id' => Auth::user()->state_id,
                'city_id' => Auth::user()->city_id,
                'department_name' => $request->department_name,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];
            $saveRequest =  UserDepartmentRequest::insert($insertArray);
            return res_success('Request saved successfully.');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function departmentFollow(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $user_id = $request->user_id;
            $department_id = $request->department_id;
            $badge_id = $request->badge_id;
            $followedDepartment = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $department_id)->first();
            $followedBadges  = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $badge_id)->first();
            if ($department_id) {
                if ($followedDepartment) {
                    if ($followedDepartment->status == 0) {
                        $update = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $department_id)->update(['status' => 1]);
                        return res_success('Department followed successfully');
                    } else {
                        $update = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $department_id)->update(['status' => 0]);
                        return res_success('Department Unfollowed successfully');
                    }
                } else {
                    $insertFollowed = [
                        'user_id' => $user_id,
                        'department_id' => $department_id,
                        'created_at' => CURRENT_DATE,
                        'updated_at' => CURRENT_DATE,
                    ];
                    $followdata =  UserDepartmentFollow::insert($insertFollowed);
                    return res_success('Department followed successfully');
                }
            }
            if ($badge_id) {
                if ($followedBadges) {
                    if ($followedBadges->status == 0) {
                        $update = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $badge_id)->update(['status' => 1]);
                        return res_success('Badge followed successfully');
                    } else {
                        $update = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $badge_id)->update(['status' => 0]);
                        return res_success('Badge Unfollowed successfully');
                    }
                } else {
                    $insertFollowed = [
                        'user_id' => $user_id,
                        'badge_id' => $badge_id,
                        'created_at' => CURRENT_DATE,
                        'updated_at' => CURRENT_DATE,
                    ];
                    $followdata =  UserDepartmentBadgeFollow::insert($insertFollowed);
                    return res_success('Badge followed successfully');
                }
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
