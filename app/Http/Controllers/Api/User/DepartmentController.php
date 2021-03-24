<?php

namespace App\Http\Controllers\Api\User;

use App\Post;
use App\User;
use Exception;
use App\Department;
use App\DepartmentBadge;
use Illuminate\Http\Request;
use App\UserDepartmentFollow;
use App\UserDepartmentRequest;
use App\UserDepartmentBadgeFollow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    /**
     * save department request .
     *
     * @return Json
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
    public function getBadgesOfDepartment(Request $request)
    {
        try {
            //get  badges w.r.t given department_id

            $department_id = $request->department_id;
            $badges =  DepartmentBadge::select(
                'department_badges.department_id',
                'department_badges.badge_number',
                'department_badges.id as badge_id'
            )->leftjoin("departments", function ($join) {
                $join->on('departments.id', '=', 'department_badges.department_id');
            })
                ->where('department_badges.status', ACTIVE)->where('department_id', $department_id)->get();

            foreach ($badges as $badge) {
                $total_reviews = Post::where('badge_id', $badge->badge_id)->where('consider_rating', 1)->count();
                $badge['rating'] = 0;
                $badge['total_reviews'] = $total_reviews;
                $rating = Post::select('rating')->where('badge_id', $badge->badge_id)->where('consider_rating', 1)->avg('rating');
                $badge['rating'] = ($rating) ? $rating : 0;
                $is_follow = UserDepartmentBadgeFollow::where('badge_id', $badge->badge_id)->where('user_id', Auth::user()->id)->first();
                $badge['is_follow'] = ($is_follow) ? $is_follow->status : 0;
            }
            $badges = $badges->toArray();
            usort($badges, function ($is_follow1, $is_follow2) {
                if ($is_follow1['is_follow'] < $is_follow2['is_follow'])
                    return 1;
                else if ($is_follow1['is_follow'] > $is_follow2['is_follow'])
                    return -1;
                else
                    return 0;
            });
            return res_success(trans('messages.successFetchList'), (object) array('departmentBadges' => $badges));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getDepartmentOfBadge(Request $request)
    {
        try {
            $badge_id =  $request->badge_id;
            $siteUrl = env('APP_URL');
            $badges =  DepartmentBadge::select(
                'departments.id as department_id',
                'departments.department_name',
                DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image")

            )->leftjoin("departments", function ($join) {
                $join->on('departments.id', '=', 'department_badges.department_id');
            })
                ->where('department_badges.status', ACTIVE)->where('department_badges.id', $badge_id)->get();

            foreach ($badges as $badge) {
                $total_reviews = Post::where('department_id', $badge->department_id)->where('consider_rating', 1)->count();
                $badge['rating'] = 0;
                $badge['total_reviews'] = $total_reviews;
                $rating = Post::select('rating')->where('department_id', $badge->department_id)->where('consider_rating', 1)->avg('rating');
                $badge['rating'] = ($rating) ? $rating : 0;
                $is_follow = UserDepartmentFollow::where('department_id', $badge->department_id)->where('user_id', Auth::user()->id)->first();
                $badge['is_follow'] = ($is_follow) ? $is_follow->status : 0;
            }
            $badges = $badges->toArray();
            usort($badges, function ($is_follow1, $is_follow2) {
                if ($is_follow1['is_follow'] < $is_follow2['is_follow'])
                    return 1;
                else if ($is_follow1['is_follow'] > $is_follow2['is_follow'])
                    return -1;
                else
                    return 0;
            });
            return res_success(trans('messages.successFetchList'), (object) array('department' => $badges));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
