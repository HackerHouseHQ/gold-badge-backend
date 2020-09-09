<?php

namespace App\Http\Controllers\Api\User;

use App\City;
use App\User;
use Exception;
use App\Country;
use Carbon\Carbon;
use App\Department;
use App\CountryState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function getCountryList()
    {
        /**
         * Show country List.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $country = Country::select('id as country_id', 'country_name')->get();
            if (count($country) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('countryList' => $country));
            } else {
                return res_success('No record found', (object) array('countryList' => $country));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getStateList(Request $request)
    {
        /**
         * Show state List.
         *
         * @param int $countryId
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $countryId = $request->country_id;
            $state =  CountryState::select('id as state_id', 'country_id', 'state_name')->where('country_id',  $countryId)->get();
            if (count($state) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('stateList' => $state));
            } else {
                return res_success('No record found', (object) array('stateList' => $state));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getCityList(Request $request)
    {
        /**
         * Show city List.
         *
         * @param int $countryId , $stateId
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $countryId = $request->country_id;
            $stateId = $request->state_id;
            $city = City::select('id as city_id', 'state_id', 'country_id', 'city_name')
                ->where('country_id', $countryId)
                ->where('state_id', $stateId)
                ->get();
            if (count($city) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('cityList' => $city));
            } else {
                return res_success('No record found', (object) array('cityList' => $city));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function checkMobileNoExistence(Request $request)
    {
        /**
         * Check mobile number existence.
         *
         * @param int $mobileNumber
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $mobileNumber = $request->mobile_no;
            $checkmobile = User::where('mobil_no', $mobileNumber)->first();

            if (!empty($checkmobile)) {
                throw new Exception(trans('messages.recordExists'), DATA_EXISTS);
            } else {
                throw new Exception(trans('messages.numberNotExists'), NOT_EXISTS);
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function followDepartmentList(Request $request)
    {
        try {
            $countryId = $request->country_id;
            $stateId = $request->state_id;
            $department = Department::getDepartmentList($countryId, $stateId);
            if (count($department) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('departmentFollowList' => $department));
            } else {
                return res_success('No record found', (object) array('departmentFollowList' => $department));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function signUp(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'username' => 'required|string',
                    'email' => 'required|email',
                    'mobile_no' => 'required|numeric',
                    'country_id' => 'required|numeric',
                    'state_id' => 'required|numeric',
                    'city_id' => 'required|numeric',
                ]
            );
            /**
             * Check input parameter validation
             */

            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }

            $insertData = [
                'first_name' => $request->name,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'mobil_no' => $request->mobile_no,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];
            $userInsetId = User::insertGetId($insertData);
            $user = User::where('id', $userInsetId)->first();
            $resulToken = $user->createToken('');
            $token = $resulToken->token;
            $token->save();
            $user->access_token = $resulToken->accessToken;
            $user->token_type = 'Bearer';
            $user->expire_at = Carbon::parse($resulToken->token->expires_at)->toDateTimeString();
            return res_success('User  Social Signup Successfully', $user);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
