<?php

namespace App\Http\Controllers\Api\User;

use App\City;
use App\Post;
use App\User;
use Exception;
use App\Country;
use App\PostImage;
use Carbon\Carbon;
use App\Department;
use App\CountryState;
use App\DepartmentBadge;
use App\PostBadgeImage;
use Illuminate\Http\Request;
use App\UserDepartmentFollow;
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
    public function DepartmentList(Request $request)
    {
        /**
         * fetch department list.
         *
         * @param int $countryId , $stateId , $cityId
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */

        try {
            $countryId = $request->country_id;
            $stateId = $request->state_id;
            $cityId = $request->city_id;
            $departmentAll = Department::getDepartmentListAll($countryId, $stateId, $cityId);
            $department = Department::getDepartmentList($countryId, $stateId, $cityId);
            foreach ($departmentAll as $value) {
                $value['total_reviews'] = 0;
                $value['rating'] = 0;
                foreach ($department as $k => $v) {
                    if ($v->department_id  == $value->department_id) {
                        $value['total_reviews'] = $v->total_reviews;
                        $value['rating'] = $v->rating;
                    }
                }
            }
            $badges = DepartmentBadge::getDepartmentBadge($countryId, $stateId, $cityId);

            if (count($department) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('departmentFollowList' => $departmentAll, 'departmentBadges' => $badges));
            } else {
                return res_success('No record found', (object) array('departmentFollowList' => $department));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function signUp(Request $request)
    {
        /**
         * sign up user.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'user_name' => 'required|string|unique:users',
                    'email' => 'required|email',
                    'mobile_no' => 'required|numeric|digits:10',
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
            $user->image = ($user->image) ? env('APP_URL')  . '/public/storage/uploads/user_image/' . $user->image : "";
            return res_success('User  Signup Successfully', $user);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    public function checkUserNameEmail(Request $request)
    {
        /**
         * Check username  and email existence.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $email = $request->email;
            $username =  $request->user_name;
            if (!empty($email) && !empty($username)) {
                $checkEmail = User::where('email', $email)->where('user_name', $username)->first();

                if (!empty($checkEmail)) {
                    throw new Exception('This username and email already exists.', DATA_EXISTS);
                } else {
                    throw new Exception('This username and email does not exists.', NOT_EXISTS);
                }
            }
            if ($username) {
                $checkUsername = User::where('user_name', $username)->first();

                if (!empty($checkUsername)) {
                    throw new Exception('This username already exists.', DATA_EXISTS);
                } else {
                    throw new Exception('This username does not exists.', NOT_EXISTS);
                }
            }
            if ($email) {
                $checkEmail = User::where('email', $email)->first();

                if (!empty($checkEmail)) {
                    throw new Exception('This email already exists.', DATA_EXISTS);
                } else {
                    throw new Exception('This email does not exists.', NOT_EXISTS);
                }
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function savePostReview(Request $request)
    {

        /**
         * Check username  and email existence.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            if ($request->type == 1) { //department 
                $validator = Validator::make(
                    $request->all(),
                    [
                        'department_id' => 'required|numeric',
                        'rating' => 'required|numeric',
                        'comment' => 'required|string',
                        'user_id' => 'required|numeric',
                        'stay_anonymous' => 'required|boolean',
                        'uploadFile' => 'array',
                        'uploadFile.*.' => 'required|image|mimes:jpeg,png,jpg|max:10240',

                    ]
                );
                /**
                 * Check input parameter validation
                 */
                if ($validator->fails()) {
                    return res_validation_error($validator); //Sending Validation Error Message
                }
                $departmentId = $request->department_id;
                $rating = $request->rating;
                $comment = $request->comment;
                $userId = $request->user_id;
                $stayAnonymous = $request->stay_anonymous;
                $uploadFile  = $request->upLoadFile;
                $insertPostDepartment = [
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'rating' => $rating,
                    'comment' => $comment,
                    'stay_anonymous' => $stayAnonymous,
                    'flag' => 1,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE,
                ];

                $insertPostId = Post::insertGetId($insertPostDepartment);
                if (isset($uploadFile) && !empty($uploadFile)) {
                    $arr = $uploadFile;
                    if (!is_array($arr)) {
                        $arr = json_decode($arr, true);
                    }
                    $i = 1;
                    foreach ($arr as $image) {
                        $file = $image;
                        $extension = $file->getClientOriginalExtension();
                        $filename = time()  . "$i" . "." . $extension;
                        $path = storage_path() . '/app/public/uploads/post_department_image';
                        $file->move($path, $filename);
                        $insertArray = [
                            'post_id' => $insertPostId,
                            'image'  => $filename,
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE
                        ];
                        $insertData = PostImage::insert($insertArray);
                        $i++;
                    }
                }
                if ($insertData || $insertPostId) {
                    return res_success('Post Saved Successfully');
                }
            }
            if ($request->type == 2) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'department_id' => 'required|numeric',
                        'badge_id' => 'required|numeric',
                        'ratingArr' => 'required|array',
                        'comment' => 'required|string',
                        'user_id' => 'required|numeric',
                        'stay_anonymous' => 'required|boolean',
                        'uploadFile' => 'array',

                    ]
                );
                /**
                 * Check input parameter validation
                 */
                if ($validator->fails()) {
                    return res_validation_error($validator); //Sending Validation Error Message
                }
                $departmentId = $request->department_id;
                $badgeId = $request->badge_id;
                $ratingArr = $request->ratingArr;
                $comment = $request->comment;
                $userId = $request->user_id;
                $stayAnonymous = $request->stay_anonymous;
                $uploadFile  = $request->upLoadFile;
                if (isset($ratingArr) && !empty($ratingArr)) {

                    $arr = $ratingArr;
                    if (!is_array($arr)) {
                        $arr = json_decode($arr, true);
                    }
                    foreach ($arr as $rating) {
                        $insertPostBadge = [
                            'user_id' => $userId,
                            'department_id' => $departmentId,
                            'badge_id' => $badgeId,
                            'rating' => $rating,
                            'comment' => $comment,
                            'stay_anonymous' => $stayAnonymous,
                            'reason_id' => $rating['reason_id'],
                            'rating' => $rating['rating'],
                            'flag' => 2,
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE,
                        ];
                        $insertData = Post::insert($insertPostBadge);
                    }
                }

                if (isset($uploadFile) && !empty($uploadFile)) {
                    $arr = $uploadFile;
                    if (!is_array($arr)) {
                        $arr = json_decode($arr, true);
                    }
                    $i = 1;
                    foreach ($arr as $image) {
                        $file = $image;
                        $extension = $file->getClientOriginalExtension();
                        $filename = time()  . "$i" . "." . $extension;
                        $path = storage_path() . '/app/public/uploads/post_badge_image';
                        $file->move($path, $filename);
                        $insertArray = [
                            'user_id' => $userId,
                            'department_id' => $departmentId,
                            'badge_id' => $badgeId,
                            'image'  => $filename,
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE
                        ];
                        $insertData = PostBadgeImage::insert($insertArray);
                        $i++;
                    }
                }
                if ($insertData) {
                    return res_success('Post Saved Successfully');
                }
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
