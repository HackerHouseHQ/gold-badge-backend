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
use App\UserDepartmentFollow;
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
    public function DepartmentList(Request $request)
    {
        try {
            $countryId = $request->country_id;
            $stateId = $request->state_id;
            $cityId = $request->city_id;
            $department = Department::getDepartmentList($countryId, $stateId, $cityId);
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
                    'user_name' => 'required|string|unique:users',
                    'email' => 'required|email',
                    'mobile_no' => 'required|numeric|min:10',
                    'mobile_country_code' => 'required|max:4',
                    'country_id' => 'required|numeric',
                    'state_id' => 'required|numeric',
                    'city_id' => 'required|numeric',
                    'image'   => 'required|image|mimes:jpeg,png,jpg|max:10240',

                ]
            );
            /**
             * Check input parameter validation
             */


            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }
            $checkemail = User::where('email', $request->email)->first();
            if ($checkemail) {
                throw new Exception('Email already exists.', DATA_EXISTS);
            }
            $file = $request->image;
            $extension = $file->getClientOriginalExtension();
            $filename = time()  . "." . $extension;
            $path = storage_path() . '/app/public/uploads/user_image';
            $file->move($path, $filename);
            $insertData = [
                'first_name' => $request->name,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'mobil_no' => $request->mobile_no,
                'mobile_country_code' => $request->mobile_country_code,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'image'  => $filename,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];

            $userInsetId = User::insertGetId($insertData);
            if (isset($request->department_followed) && !empty($request->department_followed)) {
                $follow = json_decode($request->department_followed);
                foreach ($follow as  $followed) {
                    $insertFollowed = [
                        'user_id' => $userInsetId,
                        'department_id' => $followed,
                        'created_at' => CURRENT_DATE,
                        'updated_at' => CURRENT_DATE,
                    ];
                    UserDepartmentFollow::insert($insertFollowed);
                }
            }

            $user = User::where('id', $userInsetId)->first();
            $resulToken = $user->createToken('');
            $token = $resulToken->token;
            $token->save();
            $user->access_token = $resulToken->accessToken;
            $user->token_type = 'Bearer';
            $user->expire_at = Carbon::parse($resulToken->token->expires_at)->toDateTimeString();
            $user->image =  env('APP_URL')  . '/public/storage/uploads/user_image/' . $user->image;
            return res_success('User  Signup Successfully', $user);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
