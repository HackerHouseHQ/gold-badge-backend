<?php

namespace App\Http\Controllers\Api\User;

use App\City;
use App\Post;
use App\User;
use Exception;
use App\Country;
use App\Ethnicity;
use App\PostImage;
use Carbon\Carbon;
use App\Department;
use App\CountryState;
use App\GalleryImages;
use App\ReportReasson;
use App\ReviewReasons;
use App\DepartmentLike;
use App\DepartmentVote;
use App\PostBadgeImage;
use App\DepartmentBadge;
use App\DepartmentShare;
use App\DepartmentReport;
use App\DepartmentComment;
use Illuminate\Http\Request;
use App\DepartmentSubComment;
use App\UserDepartmentFollow;
use App\DepartmentCommentLike;
use App\DepartmentSubCommentLike;
use App\UserDepartmentBadgeFollow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

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
    private function calculatProfilePercentage($user)
    {
        $total_field_filled = 0;
        if ($user->first_name) {
            $total_field_filled += 1;
        }
        if ($user->gender) {
            $total_field_filled += 1;
        }
        if ($user->mobil_no) {
            $total_field_filled += 1;
        }
        if ($user->email) {
            $total_field_filled += 1;
        }
        if ($user->user_name) {
            $total_field_filled += 1;
        }
        if ($user->country_id) {
            $total_field_filled += 1;
        }
        if ($user->state_id) {
            $total_field_filled += 1;
        }
        if ($user->city_id) {
            $total_field_filled += 1;
        }
        if ($user->image) {
            $total_field_filled += 1;
        }
        if ($user->dob) {
            $total_field_filled += 1;
        }
        if ($user->ethnicity) {
            $total_field_filled += 1;
        }
        return $total_field_filled / 11 * 100;
        // end of calculate profile percentage 
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
            // calculate profile percentage 
            $percentage = $this->calculatProfilePercentage($user);
            $resulToken = $user->createToken('');
            $token = $resulToken->token;
            $token->save();
            $user->access_token = $resulToken->accessToken;
            $user->token_type = 'Bearer';
            $user->expire_at = Carbon::parse($resulToken->token->expires_at)->toDateTimeString();
            $user->image = ($user->image) ? env('APP_URL')  . '/public/storage/uploads/user_image/' . $user->image : "";
            $user->percentage =  $percentage;
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
    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        return imagejpeg($image, $destination_url, $quality);
    }
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
                        'media_type' =>  'nullable', // 0 =>video , 1 => image
                        'consider_rating' => 'boolean'  // 0 => d'nt consider rating  , 1=> consider rating
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
                $consider_rating = $request->consider_rating;
                $insertPostDepartment = [
                    'user_id' => $userId,
                    'department_id' => $departmentId,
                    'rating' => $rating,
                    'comment' => $comment,
                    'stay_anonymous' => $stayAnonymous,
                    'flag' => 1,
                    'user_rating' => $user_rating,
                    'consider_rating' => $consider_rating,
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
                        // $file->move($path, $filename);
                        if ($request->media_type == 1) {
                            $img = Image::make($file->getRealPath());
                            $img->orientate();
                            $img->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->save($path . '/' . $filename);
                        } else {
                            $file->move($path, $filename);
                        }




                        // if (!file_exists($path)) {
                        //     mkdir($path, 0777, true);
                        // }
                        // $filenames = $this->compress_image($file, $path . '/' . $filename, 80);
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
                        if ($getImage->media_type == 1) {
                            $filename = $getImage->image;
                            $path = storage_path() . '/app/public/uploads/post_department_image/' . $filename;
                            $galleryPath = storage_path() . '/app/public/uploads/gallery_image/' . $filename;
                            copy($galleryPath, $path);
                        }
                        if ($getImage->media_type == 0) {
                            $filename = $getImage->video;
                            $path = storage_path() . '/app/public/uploads/post_department_image/' . $filename;
                            $galleryPath = storage_path() . '/app/public/uploads/gallery_video/' . $filename;
                            copy($galleryPath, $path);
                        }
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
                        'media_type' => 'nullable', // 0 =>video , 1 => image
                        'consider_rating' => 'boolean'  // 0 => d'nt consider rating  , 1=> consider rating
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
                $consider_rating = $request->consider_rating;
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
                    'consider_rating' => $consider_rating,
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

                        if ($request->media_type == 1) {
                            $img = Image::make($file->getRealPath());
                            $img->orientate();
                            $img->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->save($path . '/' . $filename);
                        } else {
                            $file->move($path, $filename);
                        }

                        // $file->move($path, $filename);
                        // if (!file_exists($path)) {
                        //     mkdir($path, 0777, true);
                        // }
                        // $filenames = $this->compress_image($file, $path . '/' . $filename, 80);
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
                        if ($getImage->media_type == 1) {
                            $filename = $getImage->image;
                            $path = storage_path() . '/app/public/uploads/post_department_image/' . $filename;
                            $galleryPath = storage_path() . '/app/public/uploads/gallery_image/' . $filename;
                            copy($galleryPath, $path);
                        }
                        if ($getImage->media_type == 0) {
                            $filename = $getImage->video;
                            $path = storage_path() . '/app/public/uploads/post_department_image/' . $filename;
                            $galleryPath = storage_path() . '/app/public/uploads/gallery_video/' . $filename;
                            copy($galleryPath, $path);
                        }
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
                //get all reported posts reported by user
                $reportId = DepartmentReport::select('post_id')->where('user_id', $user_id)->get()->toArray();
                // create array of post_id from reported posts array
                $reportArray = array_column($reportId, 'post_id');
                $siteUrl = env('APP_URL');

                $query  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->leftJoin('department_badges', 'department_badges.id', '=', 'posts.badge_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount(['post_like' => function (Builder $query) {
                        $query->where('status', 1);
                    }])
                    ->withCount('post_share')
                    ->whereIn('posts.department_id', $departmentIdsArray)
                    ->whereNotIn('posts.id', $reportArray);
                if (!empty($search)) {
                    $query->Where(function ($q) use ($search) {
                        $q->orwhere('department_name', 'like', '%' . $search . '%');
                        $q->orwhere('user_name', 'like', '%' . $search . '%');
                        $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                        $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
                    });
                }
                $posts = $query->orderBy('posts.created_at', 'DESC')->paginate(10);
                foreach ($posts as $post) {
                    //flag =1 , 1 => department , 2 => badge 
                    if ($post->flag == 1) {
                        // get department w.r.t given department id
                        $departmentPostData = Post::where('department_id', $post->department_id)->get();
                        //get department w.r.t given department id with consider rating == 1
                        $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('status', 1)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                        $post->total_reviews    =   $departmentPostData->count();
                        $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : '0';
                        $post->badge_name       =   null;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                        $post->user_status       = 1;
                        $post->is_follow = ($user_followed_department) ? $user_followed_department->status : 0;
                    } else if ($post->flag == 2) {
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        // get department w.r.t given badge id
                        $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                        //get department w.r.t given badge id with consider rating == 1
                        $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                        $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                        $post->total_reviews    =   $badgePostData->count();
                        $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : '0';
                        $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                        $post->user_status       = 1;
                        $post->is_follow = ($user_followed_badge) ? $user_followed_badge->status : 0;
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->updated_at);
                    unset($post->consider_rating);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
            if ($request->type == 2) { //most liked post list
                $user_id = $request->user_id;
                $search = $request->search;
                $siteUrl = env('APP_URL');
                //get all reported posts reported by user
                $reportId = DepartmentReport::select('post_id')->where('user_id', $user_id)->get()->toArray();
                // create array of post_id from reported posts array
                $reportArray = array_column($reportId, 'post_id');
                $query  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->leftJoin('department_badges', 'department_badges.id', '=', 'posts.badge_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount(['post_like' => function (Builder $query) {
                        $query->where('status', 1);
                    }])
                    ->withCount('post_share')
                    ->whereNotIn('posts.id', $reportArray);

                if (!empty($search)) {
                    $query->Where(function ($q) use ($search) {
                        $q->orwhere('department_name', 'like', '%' . $search . '%');
                        $q->orwhere('user_name', 'like', '%' . $search . '%');
                        $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                        $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
                    });
                }
                $posts = $query->orderBy('post_like_count', 'desc')
                    ->paginate(10);
                foreach ($posts as $post) {
                    //flag =1 , 1 => department , 2 => badge 
                    if ($post->flag == 1) {
                        // get department w.r.t given department id
                        $departmentPostData = Post::where('department_id', $post->department_id)->get();
                        //get department w.r.t given department id with consider rating == 1
                        $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('status', 1)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                        $post->total_reviews    =   $departmentPostData->count();
                        $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : '0';
                        $post->badge_name       =   null;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                        $post->user_status       = 1;
                        $post->is_follow = ($user_followed_department) ? $user_followed_department->status : 0;
                    } else if ($post->flag == 2) {
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('status', 1)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        // get department w.r.t given badge id
                        $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                        //get department w.r.t given badge id with consider rating == 1
                        $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                        $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                        $post->total_reviews    =   $badgePostData->count();
                        $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : '0';
                        $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                        $post->user_status       = 1;
                        $post->is_follow = ($user_followed_badge) ? $user_followed_badge->status : 0;
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->updated_at);
                    unset($post->consider_rating);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
            if ($request->type == 3) //most shared post list
            {
                $user_id = $request->user_id;
                $search = $request->search;
                $siteUrl = env('APP_URL');
                //get all reported posts reported by user
                $reportId = DepartmentReport::select('post_id')->where('user_id', $user_id)->get()->toArray();
                // create array of post_id from reported posts array
                $reportArray = array_column($reportId, 'post_id');
                $query =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->leftJoin('department_badges', 'department_badges.id', '=', 'posts.badge_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount(['post_like' => function (Builder $query) {
                        $query->where('status', 1);
                    }])
                    ->withCount('post_share')
                    ->whereNotIn('posts.id', $reportArray);

                if (!empty($search)) {
                    $query->Where(function ($q) use ($search) {
                        $q->orwhere('department_name', 'like', '%' . $search . '%');
                        $q->orwhere('user_name', 'like', '%' . $search . '%');
                        $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                        $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
                    });
                }
                $posts  = $query->orderBy('post_share_count', 'desc')
                    ->paginate(10);
                foreach ($posts as $post) {
                    //flag =1 , 1 => department , 2 => badge 
                    if ($post->flag == 1) {
                        // get department w.r.t given department id
                        $departmentPostData = Post::where('department_id', $post->department_id)->get();
                        //get department w.r.t given department id with consider rating == 1
                        $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('status', 1)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                        $post->total_reviews    =   $departmentPostData->count();
                        $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : '0';
                        $post->badge_name       =   null;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                        $post->user_status       = 1;
                        $post->is_follow = ($user_followed_department) ? $user_followed_department->status : 0;
                    } else if ($post->flag == 2) {
                        $post_liked = DepartmentLike::where('user_id', $user_id)->where('status', 1)->where('post_id', $post->id)->first();
                        $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                        // get department w.r.t given badge id
                        $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                        //get department w.r.t given badge id with consider rating == 1
                        $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                        $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                        $post->total_reviews    =   $badgePostData->count();
                        $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : '0';
                        $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                        $post->is_liked          = ($post_liked) ? 1 : 0;
                        $post->is_shared          = ($post_shared) ? 1 : 0;
                        $post->user_status       = 1;
                        $post->is_follow = ($user_followed_badge) ? $user_followed_badge->status : 0;
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->updated_at);
                    unset($post->consider_rating);
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
                $post = Post::whereId($post_id)->first();
                $user = User::whereId($user_id)->first();
                $statusLike = DepartmentLike::where('user_id', $user_id)->where('post_id', $post_id)->first();
                if ($statusLike->status) {
                    $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
                    $notification = sendFCM('Gold Badge', $user->first_name . ' liked your post.', $userNotify);
                }
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
                $post = Post::whereId($post_id)->first();
                $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
                $user  =  User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
                $notification = sendFCM('Gold Badge', $user->user_name . ' shared  your post.', $userNotify);
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
            $post = Post::whereId($post_id)->first();
            $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
            $notification = sendFCM('Gold Badge', $user->user_name . ' commented on your post.', $userNotify);
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
            $post = Post::whereId($post_id)->first();
            $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
            $notification = sendFCM('Gold Badge', $user->user_name . ' commented on your post.', $userNotify);
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
            $report_message_id = $request->report_message_id;
            $insertArray = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'report_message_id' => $report_message_id,
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

            $insertVote = DepartmentVote::insert($insertArray);
            if ($insertVote) {
                $post = Post::whereId($post_id)->first();
                $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
                $user  =  User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
                $notification = sendFCM('Gold Badge', $user->user_name . ' voted on your post.', $userNotify);
                return res_success('Vote saved successfully.');
            }
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
            // calculate profile percentage 
            // calculate profile percentage 
            $percentage = $this->calculatProfilePercentage($user);
            $resulToken = $user->createToken('');
            $token = $resulToken->token;
            $token->save();
            $user->access_token = $resulToken->accessToken;
            $user->token_type = 'Bearer';
            $user->expire_at = Carbon::parse($resulToken->token->expires_at)->toDateTimeString();
            $user->image = ($user->image) ? env('APP_URL')  . '/public/storage/uploads/user_image/' . $user->image : "";
            $user->percentage = $percentage;
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
    public function departmentBadgeList(Request $request)
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
                $departmentRating = Post::where('department_id', $value->department_id)->where('flag', 1)->where('consider_rating', 1)->avg('rating');
                $departmentReviews =  Post::where('department_id', $value->department_id)->where('flag', 1)->count();
                foreach ($value->departments->badges as $key => $badge) {
                    $badgeRating = Post::where('department_id', $badge->department_id)->where('badge_id', $badge->badge_id)->where('consider_rating', 1)->where('flag', 2)->avg('rating');
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
    public function getFollowerList(Request $request)
    {
        // try {
        $countryId = $request->country_id;
        $stateId = $request->state_id;
        $cityId = $request->city_id;
        $is_followed_by_user = $request->is_followed_by_user;
        $departmentAll = Department::getDepartmentListAll($countryId, $stateId, $cityId);
        $department = Department::getDepartmentList($countryId, $stateId, $cityId);
        $departmentfollowedbyuser = [];
        foreach ($departmentAll as $value) {
            $value['total_reviews'] = 0;
            $value['rating'] = 0;
            $is_follow = UserDepartmentFollow::where('department_id', $value->department_id)->where('user_id', Auth::user()->id)->first();
            $value['is_follow'] = ($is_follow) ? $is_follow->status : 0;
            foreach ($department as $k => $v) {
                if ($v->department_id  == $value->department_id) {
                    $value['total_reviews'] = $v->total_reviews;
                    $value['rating'] = ($v->rating) ? $v->rating : 0;
                }
            }
            if ($is_followed_by_user == 1) {

                $followedDepartment = UserDepartmentFollow::where('user_id', Auth::user()->id)->where('status', 1)->get()->toArray();
                $followedDepartmentIdsArray     =   array_column($followedDepartment, 'department_id');
                if (in_array($value->department_id, $followedDepartmentIdsArray)) {
                    $departmentfollowedbyuser[] = $value;
                }
            }
        }
        if ($is_followed_by_user == 1) {
            $departmentAll = $departmentfollowedbyuser;
        } else {
            $departmentAll = $departmentAll->toArray();
        }

        usort($departmentAll, function ($is_follow1, $is_follow2) {
            if ($is_follow1['is_follow'] < $is_follow2['is_follow'])
                return 1;
            else if ($is_follow1['is_follow'] > $is_follow2['is_follow'])
                return -1;
            else
                return 0;
        });
        $badges = DepartmentBadge::getDepartmentBadge($countryId, $stateId, $cityId);
        $badgefollowedbyuser = [];
        foreach ($badges as $badge) {
            $total_reviews = Post::where('badge_id', $badge->badge_id)->count();
            $badge['rating'] = 0;
            $badge['total_reviews'] = $total_reviews;
            $rating = Post::select('rating')->where('badge_id', $badge->badge_id)->where('consider_rating', 1)->avg('rating');
            $badge['rating'] = ($rating) ? $rating : 0;
            $is_follow = UserDepartmentBadgeFollow::where('badge_id', $badge->badge_id)->where('user_id', Auth::user()->id)->first();
            $badge['is_follow'] = ($is_follow) ? $is_follow->status : 0;
            # code...
            if ($is_followed_by_user == 1) {

                $followedBadge = UserDepartmentBadgeFollow::where('user_id', Auth::user()->id)->where('status', 1)->get()->toArray();
                $followedBadgeIdsArray     =   array_column($followedBadge, 'badge_id');
                if (in_array($badge->badge_id, $followedBadgeIdsArray)) {
                    $badgefollowedbyuser[] = $badge;
                }
            }
        }
        if ($is_followed_by_user == 1) {
            $badges = $badgefollowedbyuser;
        } else {
            $badges = $badges->toArray();
        }


        usort($badges, function ($is_follow1, $is_follow2) {
            if ($is_follow1['is_follow'] < $is_follow2['is_follow'])
                return 1;
            else if ($is_follow1['is_follow'] > $is_follow2['is_follow'])
                return -1;
            else
                return 0;
        });

        return res_success(trans('messages.successFetchList'), (object) array('departmentFollowList' => $departmentAll, 'departmentBadges' => $badges));
        // } catch (Exception $e) {
        //     return res_failed($e->getMessage(), $e->getCode());
        // }
    }

    public function getDepartmentData(Request $request)
    {
        try {
            $department_id = $request->department_id;
            $siteUrl = env('APP_URL');
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }

            $user_id = $request->user_id;
            $search = $request->search;
            $filter_by_date = $request->filter_date;

            //get all reported posts reported by user
            $reportId = DepartmentReport::select('post_id')->where('user_id', $user_id)->get()->toArray();
            // create array of post_id from reported posts array
            $reportArray = array_column($reportId, 'post_id');
            $siteUrl = env('APP_URL');

            $query  =   Post::with(['post_images', 'post_vote'])
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                ->leftJoin('department_badges', 'department_badges.id', '=', 'posts.badge_id')
                ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                ->withCount('post_comment')
                ->withCount('post_like')
                ->withCount('post_share')
                ->where('posts.department_id', $department_id)
                ->whereNotIn('posts.id', $reportArray);
            if (!empty($search)) {
                $query->Where(function ($q) use ($search) {
                    $q->orwhere('department_name', 'like', '%' . $search . '%');
                    $q->orwhere('user_name', 'like', '%' . $search . '%');
                    $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                    $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
                });
            }
            if (!empty($filter_by_date) && $filter_by_date != 0) {
                $todaydate = date("Y-m-d"); // current date
                $after_one_week_date = date("Y-m-d", strtotime("-1 week"));
                $after_two_week_date = date("Y-m-d", strtotime("-2 week"));
                $month_date = date("Y-m-d", strtotime("-1 month"));
                if ($filter_by_date == 1) {
                    $fromdate1 =   $after_one_week_date;
                    $todate1 =   $todaydate;
                } elseif ($filter_by_date == 2) {
                    $fromdate1 =   $after_two_week_date;
                    $todate1 =   $todaydate;
                } elseif ($filter_by_date == 3) {
                    $fromdate1 =   $month_date;
                    $todate1 =   $todaydate;
                }
                $query->Where(function ($q) use ($fromdate1, $todate1) {
                    $q->wheredate('posts.created_at', '>=', $fromdate1);
                    $q->wheredate('posts.created_at', '<=', $todate1);
                });
            }
            $posts = $query->orderBy('created_at', 'DESC')->paginate(10);
            foreach ($posts as $post) {
                //flag =1 , 1 => department , 2 => badge 
                if ($post->flag == 1) {
                    // get department w.r.t given department id
                    $departmentPostData = Post::where('department_id', $post->department_id)->get();
                    //get department w.r.t given department id with consider rating == 1
                    $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                    $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    $post->total_reviews    =   $departmentPostData->count();
                    $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : '0';
                    $post->badge_name       =   null;
                    $post->is_liked          = ($post_liked) ? 1 : 0;
                    $post->is_shared          = ($post_shared) ? 1 : 0;
                    $post->user_status       = 1;
                } else if ($post->flag == 2) {
                    $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    // get department w.r.t given badge id
                    $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                    //get department w.r.t given badge id with consider rating == 1
                    $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                    $post->total_reviews    =   $badgePostData->count();
                    $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : '0';
                    $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                    $post->is_liked          = ($post_liked) ? 1 : 0;
                    $post->is_shared          = ($post_shared) ? 1 : 0;
                    $post->user_status       = 1;
                }
                unset($post->rating);
                unset($post->reason_id);
                unset($post->updated_at);
                unset($post->consider_rating);
            }


            $data = Department::with('country_data')->with('city_data')->with('state_data')->select(DB::raw("CONCAT('$siteUrl','storage/departname/', image) as department_image"), 'department_name', 'country_id', 'state_id', 'city_id')
                ->whereId($department_id)->first();
            $avgrating = Post::where('department_id', $department_id)->where('flag', 1)->where('consider_rating', 1)->avg('rating');
            $totalReviews = Post::where('department_id', $department_id)->where('flag', 1)->count();
            $onerating = Post::where('department_id', $department_id)->where('flag', 1)->where('rating', 1)->count();
            $tworating = Post::where('department_id', $department_id)->where('flag', 1)->where('rating', 2)->count();
            $threerating = Post::where('department_id', $department_id)->where('flag', 1)->where('rating', 3)->count();
            $fourrating = Post::where('department_id', $department_id)->where('flag', 1)->where('rating', 4)->count();
            $fiverating = Post::where('department_id', $department_id)->where('flag', 1)->where('rating', 5)->count();
            $data['country_name'] = $data->country_data->country_name;
            $data['state_name'] = $data->state_data->state_name;
            $data['city_name'] = $data->city_data->city_name;
            unset($data->country_data);
            unset($data->state_data);
            unset($data->city_data);
            $data['avgRating'] =  ($avgrating) ? number_format($avgrating, 1) : '0';
            $data['totalReviews'] = $totalReviews;
            $data['oneRating'] = $onerating;
            $data['twoRating'] = $tworating;
            $data['threeRating'] = $threerating;
            $data['fourRating'] = $fourrating;
            $data['fiveRating'] = $fiverating;
            $data['postList'] = $posts;
            return res_success('Department Data', $data);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getBadgeData(Request $request)
    {
        try {
            $badge_id = $request->badge_id;
            $filter_by_date = $request->filter_date;
            $siteUrl = env('APP_URL');
            $badge = DepartmentBadge::with('department_data')->whereId($badge_id)->first();
            $posts  = Post::where('badge_id', $badge_id)->where('flag', 2)->get()->toArray();
            $totalpost = Post::where('badge_id', $badge_id)->where('flag', 2)->count();
            $badgerating = Post::where('badge_id', $badge_id)->where('flag', 2)->where('consider_rating', 1)->avg('rating');
            $reasons =  ReportReasson::get();
            $postIdsArray     =   array_column($posts, 'id');
            $data = array();
            $data['badge_number'] = $badge->badge_number;
            $data['department_id'] = $badge->department_id;
            $data['department_name'] = $badge->department_data->department_name;
            $data['avgRating'] = ($badgerating) ? ($badgerating) : 0.0;
            $data['total_reviews'] = $totalpost;
            $data['reasons_percentage'] = [];
            foreach ($reasons as $key => $reason) {
                $total = ReviewReasons::where('reason_id', $reason->id)->whereIn('post_id', $postIdsArray)->count();
                $data['reasons_percentage'][] = [
                    'reason_name' => $reason->name,
                    'percentage' => ($total / ($totalpost * $reasons->count())) * 100
                ];
                # code...
            }
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }

            $user_id = $request->user_id;
            $search = $request->search;

            //get all reported posts reported by user
            $reportId = DepartmentReport::select('post_id')->where('user_id', $user_id)->get()->toArray();
            // create array of post_id from reported posts array
            $reportArray = array_column($reportId, 'post_id');
            $siteUrl = env('APP_URL');

            $query  =   Post::with(['post_images', 'post_vote'])
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                ->leftJoin('department_badges', 'department_badges.id', '=', 'posts.badge_id')
                ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                ->withCount('post_comment')
                ->withCount('post_like')
                ->withCount('post_share')
                ->where('posts.badge_id', $badge_id)
                ->whereNotIn('posts.id', $reportArray);
            if (!empty($search)) {
                $query->Where(function ($q) use ($search) {
                    $q->orwhere('department_name', 'like', '%' . $search . '%');
                    $q->orwhere('user_name', 'like', '%' . $search . '%');
                    $q->orwhere('posts.comment', 'like', '%' . $search . '%');
                    $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
                });
            }
            if (!empty($filter_by_date) && $filter_by_date != 0) {
                $todaydate = date("Y-m-d"); // current date
                $after_one_week_date = date("Y-m-d", strtotime("-1 week"));
                $after_two_week_date = date("Y-m-d", strtotime("-2 week"));
                $month_date = date("Y-m-d", strtotime("-1 month"));
                if ($filter_by_date == 1) {
                    $fromdate1 =   $after_one_week_date;
                    $todate1 =   $todaydate;
                } elseif ($filter_by_date == 2) {
                    $fromdate1 =   $after_two_week_date;
                    $todate1 =   $todaydate;
                } elseif ($filter_by_date == 3) {
                    $fromdate1 =   $month_date;
                    $todate1 =   $todaydate;
                }
                $query->Where(function ($q) use ($fromdate1, $todate1) {
                    $q->wheredate('posts.created_at', '>=', $fromdate1);
                    $q->wheredate('posts.created_at', '<=', $todate1);
                });
            }
            $posts = $query->orderBy('created_at', 'DESC')->paginate(10);
            foreach ($posts as $post) {
                //flag =1 , 1 => department , 2 => badge 
                if ($post->flag == 1) {
                    // get department w.r.t given department id
                    $departmentPostData = Post::where('department_id', $post->department_id)->get();
                    //get department w.r.t given department id with consider rating == 1
                    $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                    $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    $post->total_reviews    =   $departmentPostData->count();
                    $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : '0';
                    $post->badge_name       =   null;
                    $post->is_liked          = ($post_liked) ? 1 : 0;
                    $post->is_shared          = ($post_shared) ? 1 : 0;
                    $post->user_status       = 1;
                } else if ($post->flag == 2) {
                    $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                    // get department w.r.t given badge id
                    $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                    //get department w.r.t given badge id with consider rating == 1
                    $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                    $post->total_reviews    =   $badgePostData->count();
                    $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : '0';
                    $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                    $post->is_liked          = ($post_liked) ? 1 : 0;
                    $post->is_shared          = ($post_shared) ? 1 : 0;
                    $post->user_status       = 1;
                }
                unset($post->rating);
                unset($post->reason_id);
                unset($post->updated_at);
                unset($post->consider_rating);
            }
            $data['postList'] = $posts;

            return res_success('Badge Data ', $data);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function editProfile(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'user_name' => 'required|string',
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
            //check email is already exist or not except login user && check username is not already taken by other user except login user
            $checkuseremail = User::whereNotIn('id', [Auth::user()->id])->where('email', $request->email)->first();
            $checkuserusername = User::whereNotIn('id', [Auth::user()->id])->where('user_name', $request->user_name)->first();
            if ($checkuseremail) {
                throw new Exception('User already exists by this email.', DATA_EXISTS);
            }
            if ($checkuserusername) {
                throw new Exception('The user name has already been taken.', DATA_EXISTS);
            }



            $file = $request->image;
            $user = User::whereId(Auth::user()->id)->first();
            if (!empty($file) && file_exists($file)) {
                $unsetPath = storage_path() . '/app/public/uploads/user_image/' . $user->image;
                unlink($unsetPath);
            }
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
                'ethnicity' => $request->ethnicity,
                'dob' => date('Y-m-d', strtotime($request->dob)),
                'gender' => $request->gender
            ];
            $update = User::whereId(Auth::user()->id)->update($insertData);
            if ($update) {
                $user = User::whereId(Auth::user()->id)->first();
                $user->percentage = $this->calculatProfilePercentage($user);
                $user->image = ($user->image) ? env('APP_URL')  . 'storage/uploads/user_image/' . $user->image : "";
                return res_success('Profile updated successfully.', $user);
            } else {
                return res_failed('Something went wrong.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function   getEditprofileData(Request $request)
    {
        try {
            $user = User::whereId(Auth::user()->id)->first();
            if ($user->image != null) {
                $user->image =  env('APP_URL') .  'storage/uploads/user_image/' . $user->image;
            }
            return res_success('Successfully List.', $user);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
