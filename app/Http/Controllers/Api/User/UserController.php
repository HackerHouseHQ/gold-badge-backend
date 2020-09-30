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
use App\DepartmentLike;
use App\PostBadgeImage;
use App\DepartmentBadge;
use App\DepartmentShare;
use App\DepartmentComment;
use App\DepartmentCommentLike;
use App\DepartmentReport;
use Illuminate\Http\Request;
use App\DepartmentSubComment;
use App\DepartmentSubCommentLike;
use App\DepartmentVote;
use App\UserDepartmentFollow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\UserDepartmentBadgeFollow;
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

            return res_success(trans('messages.successFetchList'), (object) array('departmentFollowList' => $departmentAll, 'departmentBadges' => $badges));
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
                $arr = $request->department_followed;
                if (!is_array($arr)) {
                    $arr = json_decode($arr, true);
                }
                foreach ($arr as  $followed) {
                    $insertFollowed = [
                        'user_id' => $userInsetId,
                        'department_id' => $followed,
                        'created_at' => CURRENT_DATE,
                        'updated_at' => CURRENT_DATE,
                    ];
                    $followdata =  UserDepartmentFollow::insert($insertFollowed);
                }
            }

            if (isset($request->badges_followed) && !empty($request->badges_followed)) {
                $arr = $request->badges_followed;
                if (!is_array($arr)) {
                    $arr = json_decode($arr, true);
                }
                foreach ($arr as  $followed) {
                    $insertbadgesFollowed = [
                        'user_id' => $userInsetId,
                        'badge_id' => $followed,
                        'created_at' => CURRENT_DATE,
                        'updated_at' => CURRENT_DATE,
                    ];
                    $followdata =  UserDepartmentBadgeFollow::insert($insertbadgesFollowed);
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
         * save post review .
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
                        'upLoadFile' => 'nullable|array',
                        'media_type' =>  'boolean|nullable' // 0 =>video , 1 => image
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
                    'updated_at' => CURRENT_DATE
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
                            'media_type' => $request->media_type,
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE
                        ];
                        $insertData = PostImage::insert($insertArray);
                        $i++;
                    }
                }
                if ($insertPostId || $insertData) {
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
                        // 'ratingArr.*.reason_id' => 'required|numeric',
                        // 'ratingArr.*.rating' => 'required|numeric',
                        'comment' => 'required|string',
                        'user_id' => 'required|numeric',
                        'stay_anonymous' => 'required|boolean',
                        'upLoadFile' => 'required|array',
                        'media_type' => 'boolean|nullable' // 0 =>video , 1 => image
                        // 'upLoadFile.*' => 'required'
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
                            'updated_at' => CURRENT_DATE
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
                            'media_type' => $request->media_type,
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

    public function getPostDepartment(Request $request)
    {
        // echo "fvf"; die;
        /**
         * get post department .
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            if ($request->type == 1) {
                //  echo "da"; die;
                $user_id = $request->user_id;
                $myPost = UserDepartmentFollow::getPostDepartmentData($user_id);
                $query = UserDepartmentFollow::query()->select(
                    'posts.user_id',
                    'posts.id as post_id',
                    'users.user_name',
                    'users.image as user_image',
                    'departments.department_name',
                    'posts.created_at',
                    'posts.comment as post_content',
                    'posts.flag',
                    'posts.stay_anonymous',
                    'user_department_follows.department_id',
                    DB::raw('COUNT(posts.department_id) as total_reviews'),
                    DB::raw('AVG(posts.rating) as rating')
                )
                    ->leftjoin("departments", function ($join) {
                        $join->on('user_department_follows.department_id', '=', 'departments.id');
                    })
                    ->leftjoin("posts", function ($join) {
                        $join->on('user_department_follows.department_id', '=', 'posts.department_id');
                    })
                    ->leftjoin("users", function ($join) {
                        $join->on('posts.user_id', '=', 'users.id');
                    })
                    ->where('user_department_follows.user_id', $user_id)->groupBy('departments.id')
                    ->where('flag', 1)
                    ->get();
                $arrz = array();
                foreach ($myPost as $key => $value) {
                    foreach ($query as $k => $v) {
                        if ($v->flag == 1 && $value->flag == 1 && $v->department_id == $value->department_id) {
                            $isdepartmentLike = DepartmentLike::where('post_id', $value->post_id)->where('user_id', $user_id)->first();
                            // $departmentShareCount = DepartmentShare::where('post_id', $value->post_id)->count();
                            // $departmentCommentCount = DepartmentComment::where('post_id', $value->post_id)->count();
                            $value['total_reviews'] = $v->total_reviews;
                            $value['rating'] = number_format($v->rating,  1);
                            if ($isdepartmentLike) {
                                $value['is_liked'] = ($isdepartmentLike->status == 1) ? 1 : 0;
                            } else {
                                $value['is_liked'] = 0;
                            }


                            // $value['like_count'] = $departmentLikeCount;
                            // $value['comment_count'] = $departmentCommentCount;
                            // $value['share_count'] = $departmentShareCount;
                            unset($value->flag);
                        }
                    }
                }
                return res_success('Fetch List', array('postList' => $myPost));
            }
            if ($request->type == 2) {
                $user_id = $request->user_id;
                $myPost = UserDepartmentFollow::getPostDepartmentDataLike($user_id);
                $query = Post::query()->select(
                    'posts.user_id',
                    'posts.id as post_id',
                    'users.user_name',
                    'users.image as user_image',
                    'departments.department_name',
                    'posts.created_at',
                    'posts.comment as post_content',
                    'posts.flag',
                    'posts.department_id',
                    'posts.stay_anonymous',
                    DB::raw('COUNT(posts.department_id) as total_reviews'),
                    DB::raw('AVG(posts.rating) as rating')
                )
                    ->leftjoin("departments", function ($join) {
                        $join->on('posts.department_id', '=', 'departments.id');
                    })
                    ->leftjoin("users", function ($join) {
                        $join->on('posts.user_id', '=', 'users.id');
                    })
                    ->groupBy('departments.id')
                    ->where('flag', 1)
                    ->get();
                $arrz = array();
                foreach ($myPost as $key => $value) {
                    foreach ($query as $k => $v) {
                        if ($v->flag == 1 && $value->flag == 1 && $v->department_id == $value->department_id) {
                            // $departmentLikeCount = DepartmentLike::where('post_id', $value->post_id)->count();
                            // $departmentShareCount = DepartmentShare::where('post_id', $value->post_id)->count();
                            // $departmentCommentCount = DepartmentComment::where('post_id', $value->post_id)->count();
                            $value['total_reviews'] = $v->total_reviews;
                            $value['rating'] = number_format($v->rating,  1);
                            // $value['like_count'] = $departmentLikeCount;
                            // $value['comment_count'] = $departmentCommentCount;
                            // $value['share_count'] = $departmentShareCount;
                            $isdepartmentLike = DepartmentLike::where('post_id', $value->post_id)->where('user_id', $user_id)->first();
                            if ($isdepartmentLike) {
                                $value['is_liked'] = ($isdepartmentLike->status == 1) ? 1 : 0;
                            } else {
                                $value['is_liked'] = 0;
                            }
                            unset($value->flag);
                        }
                    }
                }
                return res_success('Fetch List', array('postList' => $myPost));
            }
            if ($request->type == 3) {
                $user_id = $request->user_id;
                $myPost = UserDepartmentFollow::getPostDepartmentDataShare($user_id);
                $query = Post::query()->select(
                    'posts.user_id',
                    'posts.id as post_id',
                    'users.user_name',
                    'users.image as user_image',
                    'departments.department_name',
                    'posts.created_at',
                    'posts.comment as post_content',
                    'posts.flag',
                    'posts.department_id',
                    'posts.stay_anonymous',
                    DB::raw('COUNT(posts.department_id) as total_reviews'),
                    DB::raw('AVG(posts.rating) as rating')
                )
                    ->leftjoin("departments", function ($join) {
                        $join->on('posts.department_id', '=', 'departments.id');
                    })
                    ->leftjoin("users", function ($join) {
                        $join->on('posts.user_id', '=', 'users.id');
                    })
                    ->groupBy('departments.id')
                    ->where('flag', 1)
                    ->get();
                $arrz = array();
                foreach ($myPost as $key => $value) {
                    foreach ($query as $k => $v) {
                        if ($v->flag == 1 && $value->flag == 1 && $v->department_id == $value->department_id) {
                            // $departmentLikeCount = DepartmentLike::where('post_id', $value->post_id)->count();
                            // $departmentShareCount = DepartmentShare::where('post_id', $value->post_id)->count();
                            // $departmentCommentCount = DepartmentComment::where('post_id', $value->post_id)->count();
                            $value['total_reviews'] = $v->total_reviews;
                            $value['rating'] = number_format($v->rating,  1);
                            $isdepartmentLike = DepartmentLike::where('post_id', $value->post_id)->where('user_id', $user_id)->first();
                            if ($isdepartmentLike) {
                                $value['is_liked'] = ($isdepartmentLike->status == 1) ? 1 : 0;
                            } else {
                                $value['is_liked'] = 0;
                            }
                            // $value['like_count'] = $departmentLikeCount;
                            // $value['comment_count'] = $departmentCommentCount;
                            // $value['share_count'] = $departmentShareCount;
                            unset($value->flag);
                        }
                    }
                }
                return res_success('Fetch List', array('postList' => $myPost));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    public function savePostDepartmentLike(Request $request)
    {
        /**
         * save post department Like .
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $alreadyLiked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post_id)->first();
            if ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 1) {
                $insertData =  DepartmentLike::where('user_id', $user_id)->where('post_id', $post_id)->update(['status' => 0]);
            } elseif ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 0) {
                $insertData =  DepartmentLike::where('user_id', $user_id)->where('post_id', $post_id)->update(['status' => 1]);
            } else {
                $insertArray = [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE
                ];
                $insertData = DepartmentLike::insert($insertArray);
            }
            if ($insertData) {
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function savePostDepartmentShare(Request $request)
    {
        /**
         * save post department Share .
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            // $alreadyLiked = DepartmentShare::where('user_id', $user_id)->where('post_id', $post_id)->first();
            // if ($alreadyLiked) {
            //     throw new Exception('You have already liked this post.', DATA_EXISTS);
            // }
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];
            $insertData = DepartmentShare::insert($insertArray);
            if ($insertData) {
                return res_success('Your share has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    public function  savePostDepartmentComment(Request $request)
    {
        /**
         * save post department comment .
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $comment = $request->comment;
            // $alreadyLiked = DepartmentShare::where('user_id', $user_id)->where('post_id', $post_id)->first();
            // if ($alreadyLiked) {
            //     throw new Exception('You have already liked this post.', DATA_EXISTS);
            // }
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'comment' => $comment,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];
            $insertData = DepartmentComment::insert($insertArray);
            if ($insertData) {
                return res_success('Your comment has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function  savePostDepartmentSubComment(Request $request)
    {
        /**
         * save post department sub comment .
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $sub_comment = $request->sub_comment;
            $comment_id = $request->comment_id;
            // $alreadyLiked = DepartmentShare::where('user_id', $user_id)->where('post_id', $post_id)->first();
            // if ($alreadyLiked) {
            //     throw new Exception('You have already liked this post.', DATA_EXISTS);
            // }
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'comment_id' => $comment_id,
                'sub_comment' => $sub_comment,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];
            $insertData = DepartmentSubComment::insert($insertArray);
            if ($insertData) {
                return res_success('Your sub comment has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getPostDepartmentCommentList(Request $request)
    {
        /**
         *  post department  comment  list.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $user_id = $request->user_id;
            $post_id = $request->post_id;
            $siteUrl = env('APP_URL');
            $getComment = DepartmentComment::with('sub_comment')->select(
                'department_comments.id as comment_id',
                'user_id',
                'post_id',
                'comment',
                'users.user_name',
                DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image")
            )->where('post_id', $post_id)
                ->leftjoin("users", function ($join) {
                    $join->on('department_comments.user_id', '=', 'users.id');
                })->get();
            foreach ($getComment as $key => $value) {
                $like_count = DepartmentCommentLike::where('comment_id', $value->comment_id)->where('post_id', $value->post_id)->count();
                $reply_count = DepartmentSubComment::where('comment_id', $value->comment_id)->where('post_id', $value->post_id)->count();
                $is_comment_like = DepartmentCommentLike::where('user_id', $user_id)->where('comment_id', $value->comment_id)->where('post_id', $value->post_id)->first();

                $value['comment_like_count'] = $like_count;
                $value['comment_reply_count'] = $reply_count;
                $value['is_commment_like'] = ($is_comment_like)  ?   $is_comment_like->status : 0;
                foreach ($value->sub_comment as $k => $v) {
                    $like_sub_count =   DepartmentSubCommentLike::where('sub_comment_id', $v->sub_comment_id)->where('comment_id', $value->comment_id)->where('post_id', $value->post_id)->count();
                    $is_sub_comment_like = DepartmentSubCommentLike::where('user_id', $user_id)->where('sub_comment_id', $v->sub_comment_id)->where('comment_id', $value->comment_id)->where('post_id', $value->post_id)->first();
                    $v['sub_comment_like_count'] = $like_sub_count;
                    $v['is_sub_commment_like'] = ($is_sub_comment_like) ? $is_sub_comment_like->status : 0;
                }
            }
            return res_success('Comment List', array('commentList' => $getComment));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function savePostReport(Request $request)
    {
        /**
         * save post department  report.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $user_id = $request->user_id;
            $post_id = $request->post_id;
            $message = $request->message;
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'message' => $message,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];

            $insertReport = DepartmentReport::insert($insertArray);
            if ($insertArray)
                return res_success('Report saved successfully.');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function savePostVote(Request $request)
    {
        /**
         * save post department  vote.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $user_id = $request->user_id;
            $post_id = $request->post_id;
            $rating = $request->rating;
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'rating' => $rating,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];

            $insertReport = DepartmentVote::insert($insertArray);
            if ($insertArray)
                return res_success('Vote saved successfully.');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function login(Request $request)
    {
        /**
         * login.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */

        try {

            $validator = Validator::make(
                $request->all(),
                [

                    'mobile_no' => 'numeric|digits:10|nullable',
                    'email' =>  'email|nullable'


                ]
            );
            /**
             * Check input parameter validation
             */

            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }
            if ($request->mobile_no === null && $request->email === null) {
                throw new Exception(trans('Email or Mobile number is Required'), 418);
            }
            if ($request->mobile_no) {
                $user = User::where('mobil_no', $request->mobile_no)->first();
                if (!$user) {
                    throw new Exception(trans('messages.numberNotExists'), NOT_EXISTS);
                }
            }
            if ($request->email) {
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    throw new Exception(trans('Email does not exists.'), NOT_EXISTS);
                }
            }

            $resulToken = $user->createToken('');
            $token = $resulToken->token;
            $token->save();
            $user->access_token = $resulToken->accessToken;
            $user->token_type = 'Bearer';
            $user->expire_at = Carbon::parse($resulToken->token->expires_at)->toDateTimeString();
            $user->image = ($user->image) ? env('APP_URL')  . '/public/storage/uploads/user_image/' . $user->image : "";
            return res_success('User  login  Successfully', $user);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function deparmentBadgeList(Request $request)
    {
        try {
            $callback = function ($query) {
                $query->where('status', ACTIVE);
            };
            $siteUrl = env('APP_URL');

            $departmentBadge = UserDepartmentBadgeFollow::whereHas('badge.department_data', $callback)->whereHas('badge', $callback)->with(['badge.department_data' => $callback, 'badge' => $callback])
                ->where('user_id', $request->user_id)->get();

            $department = UserDepartmentFollow::whereHas('departments', $callback)->with(['departments.badges' => $callback])->where('user_id', $request->user_id)->get();
            $arrDepartment = [];
            foreach ($department as $key => $value) {
                $departmentRating = Post::where('department_id', $value->department_id)->where('flag', 1)->avg('rating');
                $departmentReviews =  Post::where('department_id', $value->department_id)->where('flag', 1)->count();
                foreach ($value->departments->badges as $key => $badge) {
                    $badgeRating = Post::where('department_id', $badge->department_id)->where('badge_id', $badge->badge_id)->where('flag', 2)->avg('rating');
                    $badgeReviews = Post::where('department_id', $badge->department_id)->where('badge_id', $badge->badge_id)->where('flag', 2)->count();
                    $badge['total_reviews'] = $badgeReviews;
                    $badge['rating'] = ($badgeRating) ? $badgeRating : 0;
                }
                $arrDepartment[] = [
                    'user_id' => $value->user_id,
                    'department_id' => $value->department_id ?? "",
                    'department_name' => $value->departments->department_name ?? "",
                    'department_image' => ($value->departments->image) ? $siteUrl = env('APP_URL') . 'storage/departname/' . $value->departments->image : null,
                    'total_reviews' => $departmentReviews,
                    'rating' => ($departmentRating) ? $departmentRating : 0,
                    'badges' => $value->departments->badges,


                ];
            }
            $arrDepartmentBadge = [];
            foreach ($departmentBadge as $key => $value) {
                $arrDepartmentBadge[] = [
                    'user_id' => $value->user_id,
                    'badge_id' => $value->badge_id,
                    'department_id' => $value->badge->department_id ?? "",
                    'department_name' => $value->badge->department_data->department_name ?? "",
                    'badge_number' => $value->badge->badge_number

                ];
            }
            return res_success(trans('messages.successFetchList'), array('departmentList' => $arrDepartment, 'departmentBadgeList' => $arrDepartmentBadge));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
