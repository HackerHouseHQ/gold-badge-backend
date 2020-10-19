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
use App\GalleryImages;
use App\UserDepartmentFollow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\ReviewReasons;
use App\UserDepartmentBadgeFollow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Show country List.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function getCountryList()
    {
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
    /**
     * Show state List.
     *
     * @param int $countryId
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function getStateList(Request $request)
    {
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
    /**
     * Show city List.
     *
     * @param int $countryId , $stateId
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function getCityList(Request $request)
    {
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
    /**
     * Check mobile number existence.
     *
     * @param int $mobileNumber
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function checkMobileNoExistence(Request $request)
    {
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
    /**
     * fetch department list.
     *
     * @param int $countryId , $stateId , $cityId
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function DepartmentList(Request $request)
    {

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
    /**
     * sign up user.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */

    public function signUp(Request $request)
    {
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

            if (isset($request->badges_followed)) {
                $arrbadges = json_decode($request->badges_followed, true);
                foreach ($arrbadges as  $badge) {
                    $insertbadgesFollowed = [
                        'user_id' => $userInsetId,
                        'badge_id' => $badge,
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

    /**
     * Check username  and email existence.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function checkUserNameEmail(Request $request)
    {
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
    /**
     * save post review .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function savePostReview(Request $request)
    {

        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            if ($request->type == 1) { //department 
                $validator = Validator::make(
                    $request->all(),
                    [
                        'department_id' => 'required|numeric',
                        'rating' => 'required|numeric',
                        'comment' => 'required|string',
                        'user_id' => 'required|numeric',
                        'stay_anonymous' => 'required|boolean',
                        // 'upLoadFile' => 'nullable|array',
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
                $uploadSaveFile =  $request->uploadSaveFile;
                $user_rating  = $request->user_rating;
                $insertPostDepartment = [
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'rating' => $rating,
                    'comment' => $comment,
                    'stay_anonymous' => $stayAnonymous,
                    'flag' => 1,
                    'user_rating' => $user_rating,
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
                if (isset($uploadSaveFile) && !empty($uploadSaveFile)) {
                    $arrSave = $uploadSaveFile;
                    if (!is_array($arrSave)) {
                        $arrSave = json_decode($arrSave, true);
                    }
                    $i = 1;
                    foreach ($arrSave as $image) {
                        $getImage = GalleryImages::whereId($image)->first();
                        $filename = $getImage->image;
                        $path = storage_path() . '/app/public/uploads/post_department_image/' . $filename;
                        $galleryPath = storage_path() . '/app/public/uploads/gallery_image/' . $filename;
                        copy($galleryPath, $path);
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
                        // 'upLoadFile' => 'required|array',
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
                $total_rating = $request->total_rating;
                $user_rating  = $request->user_rating;
                $uploadSaveFile =  $request->uploadSaveFile;
                $insertPostBadge = [
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'badge_id' => $badgeId,
                    'rating' => $total_rating,
                    'comment' => $comment,
                    'stay_anonymous' => $stayAnonymous,
                    'rating' => $total_rating,
                    'flag' => 2,
                    'user_rating' => $user_rating,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE
                ];
                $insertPostBadgeId = Post::insertGetId($insertPostBadge);
                if (isset($ratingArr) && !empty($ratingArr)) {
                    $arr = $ratingArr;
                    if (!is_array($arr)) {
                        $arr = json_decode($arr, true);
                    }
                    foreach ($arr as $ratings) {
                        $insertRatingArray = [
                            'post_id' => $insertPostBadgeId,
                            'reason_id' => $ratings['reason_id'],
                            'rating' => $ratings['rating'],
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE
                        ];
                        $insertReason = ReviewReasons::insert($insertRatingArray);
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
                        $path = storage_path() . '/app/public/uploads/post_department_image';
                        $file->move($path, $filename);
                        $insertArray = [
                            'post_id' => $insertPostBadgeId,
                            'image'  => $filename,
                            'media_type' => $request->media_type,
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE
                        ];
                        $insertData = PostImage::insert($insertArray);
                        $i++;
                    }
                }
                if (isset($uploadSaveFile) && !empty($uploadSaveFile)) {
                    $arrSave = $uploadSaveFile;
                    if (!is_array($arrSave)) {
                        $arrSave = json_decode($arrSave, true);
                    }
                    $i = 1;
                    foreach ($arrSave as $image) {
                        $getImage = GalleryImages::whereId($image)->first();
                        $filename = $getImage->image;
                        $path = storage_path() . '/app/public/uploads/post_department_image/' . $filename;
                        $galleryPath = storage_path() . '/app/public/uploads/gallery_image/' . $filename;
                        copy($galleryPath, $path);
                        $insertArray = [
                            'post_id' => $insertPostBadgeId,
                            'image'  => $filename,
                            'media_type' => $request->media_type,
                            'created_at' => CURRENT_DATE,
                            'updated_at' => CURRENT_DATE
                        ];
                        $insertData = PostImage::insert($insertArray);
                        $i++;
                    }
                }
                return res_success('Post Saved Successfully');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    /**
     * get post department .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function getPostDepartment(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            if ($request->type == 1) { //recent post list
                $user_id = $request->user_id;
                $search = $request->search;
                // Getting department ids followed by the user
                $departmentIds  =   UserDepartmentFollow::select('department_id')->where('user_id', $user_id)->get()->toArray();
                // Creating deaprtment ids array from array of arrays
                $departmentIdsArray     =   array_column($departmentIds, 'department_id');
                $siteUrl = env('APP_URL');

                $query  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount('post_like')
                    ->withCount('post_share')
                    ->whereIn('department_id', $departmentIdsArray);
                if (!empty($search)) {
                    $query->Where(function ($q) use ($search) {
                        $q->orwhere('department_name', 'like', '%' . $search . '%');
                        $q->orwhere('user_name', 'like', '%' . $search . '%');
                        $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                    });
                }
                $posts = $query->orderBy('created_at', 'DESC')->paginate(10);
                foreach ($posts as $post) {
                    if ($post->flag == 1) {
                        $departmentPostData = Post::where('department_id', $post->department_id)->get();
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post->total_reviews    =   $departmentPostData->count();
                        $post->avg_rating       =  ($departmentPostData->avg('rating')) ? number_format($departmentPostData->avg('rating'), 1) : 0;
                        $post->badge_name       =   null;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                    } else if ($post->flag == 2) {
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                        $post->total_reviews    =   $badgePostData->count();
                        $post->avg_rating       =   ($badgePostData->avg('rating')) ? number_format($badgePostData->avg('rating'), 1) : 0;
                        $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->updated_at);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
            if ($request->type == 2) { //most liked post list
                $user_id = $request->user_id;
                $search = $request->search;
                $siteUrl = env('APP_URL');
                $query  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount('post_like')
                    ->withCount('post_share');
                if (!empty($search)) {
                    $query->Where(function ($q) use ($search) {
                        $q->orwhere('department_name', 'like', '%' . $search . '%');
                        $q->orwhere('user_name', 'like', '%' . $search . '%');
                        $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                    });
                }
                $posts = $query->orderBy('post_like_count', 'desc')
                    ->paginate(10);
                foreach ($posts as $post) {
                    if ($post->flag == 1) {
                        $departmentPostData = Post::where('department_id', $post->department_id)->get();
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post->total_reviews    =   $departmentPostData->count();
                        $post->avg_rating       =  ($departmentPostData->avg('rating')) ? number_format($departmentPostData->avg('rating'), 1) : 0;
                        $post->badge_name       =   null;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                    } else if ($post->flag == 2) {
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post->total_reviews    =   $badgePostData->count();
                        $post->avg_rating       =   ($badgePostData->avg('rating')) ? number_format($badgePostData->avg('rating'), 1) : 0;
                        $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->updated_at);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
            if ($request->type == 3) //most shared post list
            {
                $user_id = $request->user_id;
                $search = $request->search;
                $siteUrl = env('APP_URL');
                $query =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount('post_like')
                    ->withCount('post_share');
                if (!empty($search)) {
                    $query->Where(function ($q) use ($search) {
                        $q->orwhere('department_name', 'like', '%' . $search . '%');
                        $q->orwhere('user_name', 'like', '%' . $search . '%');
                        $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                    });
                }
                $posts  = $query->orderBy('post_share_count', 'desc')
                    ->paginate(10);
                foreach ($posts as $post) {
                    if ($post->flag == 1) {
                        $departmentPostData = Post::where('department_id', $post->department_id)->get();
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post->total_reviews    =   $departmentPostData->count();
                        $post->avg_rating       =  ($departmentPostData->avg('rating')) ? number_format($departmentPostData->avg('rating'), 1) : 0;
                        $post->badge_name       =   null;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                    } else if ($post->flag == 2) {
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                        $post->total_reviews    =   $badgePostData->count();
                        $post->avg_rating       =    ($badgePostData->avg('rating')) ? number_format($badgePostData->avg('rating'), 1) : 0;
                        $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->updated_at);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    /**
     * save post department Like .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function savePostDepartmentLike(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
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
                $userNotify = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
                $notification = sendFCM('Gold Badge', 'Commented on your post.', $userNotify);
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * save post department Share .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function savePostDepartmentShare(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $alreadyShared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post_id)->first();
            if ($alreadyShared) {
                throw new Exception('You have already shared this post.', DATA_EXISTS);
            }
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'created_at' => CURRENT_DATE,
                'updated_at' => CURRENT_DATE
            ];
            $insertData = DepartmentShare::insert($insertArray);
            if ($insertData) {
                $userNotify = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
                $notification = sendFCM('Gold Badge', 'Commented on your post.', $userNotify);
                return res_success('Your share has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }


    /**
     * save post department comment .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function  savePostDepartmentComment(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
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
            $insertDataId = DepartmentComment::insertGetId($insertArray);
            $siteUrl = env('APP_URL');
            $comment_like_count  = DepartmentCommentLike::where('comment_id', $insertDataId)->count();
            $comment_reply_count = DepartmentSubComment::where('comment_id', $insertDataId)->count();
            $is_comment_like = DepartmentCommentLike::where('comment_id', $insertDataId)->first();
            $user = User::select('user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"))->whereId($user_id)->first();
            $data = [
                "comment_id" => $insertDataId,
                "user_id" => $user_id,
                "post_id" => $post_id,
                "comment" => $comment,
                "user_name" => $user->user_name,
                "user_image" => $user->user_image,
                "comment_like_count" => $comment_like_count,
                "comment_reply_count" => $comment_reply_count,
                "is_commment_like" => ($is_comment_like) ? 1 : 0
            ];
            $userNotify = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            $notification = sendFCM('Gold Badge', 'Commented on your post.', $userNotify);
            return res_success('Your comment has been saved successfully.', $data);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * save post department sub comment .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function  savePostDepartmentSubComment(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
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
            $insertDataId = DepartmentSubComment::insertGetId($insertArray);
            $sub_comment_data = DepartmentSubComment::whereId($insertDataId)->first();
            $siteUrl = env('APP_URL');
            $sub_comment_like_count = DepartmentSubCommentLike::where('sub_comment_id', $insertDataId)->count();
            $is_sub_commment_like = DepartmentSubCommentLike::where('sub_comment_id', $insertDataId)->first();
            $user = User::select('user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"))->whereId($user_id)->first();

            $data = [
                "sub_comment_id" =>  $insertDataId,
                "comment_id" => $comment_id,
                "user_id" => $user_id,
                "post_id" => $post_id,
                "sub_comment" => $sub_comment,
                "user_name" => $user->user_name,
                "created_at" => $sub_comment_data->created_at,
                "user_image" => $user->user_image,
                "sub_comment_like_count" => $sub_comment_like_count,
                "is_sub_commment_like" => ($is_sub_commment_like) ? 1 : 0
            ];
            $userNotify = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            $notification = sendFCM('Gold Badge', 'Commented on your post.', $userNotify);
            return res_success('Your sub comment has been saved successfully.', $data);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     *  post department  comment  list.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function getPostDepartmentCommentList(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
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
    /**
     * save post department  report.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function savePostReport(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
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
    /**
     * save post department  vote.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function savePostVote(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
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
    /**
     * login.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */

    public function login(Request $request)
    {
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
    /**
     * department badge list.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
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
    public function updateDeviceToken(Request $request)
    {
        try {
            $user = User::whereId($request->user_id)->first();
            $user->device_token = request('device_token');
            $user->save();
            return res_success('device token update');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
