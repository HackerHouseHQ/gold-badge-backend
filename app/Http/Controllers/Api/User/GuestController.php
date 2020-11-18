<?php

namespace App\Http\Controllers\Api\User;

use App\Post;
use Exception;
use App\GuestUser;
use App\DepartmentLike;
use App\DepartmentBadge;
use App\DepartmentShare;
use Illuminate\Http\Request;
use App\UserDepartmentFollow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\User\UserController;

class GuestController extends Controller
{
    function __construct()
    {
        $this->userController = new UserController;
    }
    /**
     * guest Login .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function guestLogin(Request $request)
    {
        try {
            if ($request->device_id) {
                $guest = GuestUser::where('device_id', $request->device_id)->first();
                if ($guest) {
                    $guest->is_active = 1;
                    $guest->save();
                    return res_success('Login sucessfully');
                } else {
                    $insertArray = ['device_id' => $request->device_id];
                    $createGuest = GuestUser::create($insertArray);
                    return res_success('Login successfully');
                }
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function guestLogout(Request $request)
    {
        try {
            if ($request->device_id) {
                $guestLogout = GuestUser::where('device_id', $request->device_id)->update(['is_active' => 0]);
                return res_success('Logout successfully');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * homepage .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function homepage(Request $request)
    {
        // echo "fvf"; die;

        try {
            if ($request->type == 1) { //recent post list
                $user_id = $request->user_id;
                // // Getting department ids followed by the user
                // $departmentIds  =   UserDepartmentFollow::select('department_id')->where('user_id', $user_id)->get()->toArray();
                // // Creating deaprtment ids array from array of arrays
                // $departmentIdsArray     =   array_column($departmentIds, 'department_id');
                $siteUrl = env('APP_URL');
                $posts  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount('post_like')
                    ->withCount('post_share')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(50);
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
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->consider_rating);
                    unset($post->updated_at);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
            if ($request->type == 2) { //most liked post list
                $user_id = $request->user_id;
                $siteUrl = env('APP_URL');
                $posts  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount('post_like')
                    ->withCount('post_share')
                    ->orderBy('post_like_count', 'desc')
                    ->paginate(50);
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
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->consider_rating);
                    unset($post->updated_at);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
            if ($request->type == 3) //most shared post list
            {
                $user_id = $request->user_id;
                $siteUrl = env('APP_URL');
                $posts  =   Post::with(['post_images', 'post_vote'])
                    ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                    ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                    ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                    ->withCount('post_comment')
                    ->withCount('post_like')
                    ->withCount('post_share')
                    ->orderBy('post_share_count', 'desc')
                    ->paginate(50);
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
                    }
                    unset($post->rating);
                    unset($post->reason_id);
                    unset($post->consider_rating);
                    unset($post->updated_at);
                }
                return res_success('Fetch List', array('postList' => $posts));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
