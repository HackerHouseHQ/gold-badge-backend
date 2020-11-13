<?php

namespace App\Http\Controllers\Api\User;

use App\Post;
use App\User;
use Exception;
use App\PostImage;
use App\DepartmentLike;
use App\DepartmentVote;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class PostController extends Controller
{
    /**
     * save post department Like .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function saveCommentLike(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $comment_id = $request->comment_id;
            $alreadyLiked = DepartmentCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->first();
            if ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 1) {
                $insertData =  DepartmentCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->update(['status' => 0]);
            } elseif ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 0) {
                $insertData =  DepartmentCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->update(['status' => 1]);
            } else {
                $insertArray = [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'comment_id' => $comment_id,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE
                ];
                $insertData = DepartmentCommentLike::insert($insertArray);
            }
            if ($insertData) {
                $post = Post::whereId($post_id)->first();
                $user = User::whereId($user_id)->first();
                $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
                $notification = sendFCM('Gold Badge', $user->first_name . 'liked on your comment.', $userNotify);
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * save sub comment Like .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function saveSubCommentLike(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $comment_id = $request->comment_id;
            $sub_comment_id = $request->sub_comment_id;
            $alreadyLiked = DepartmentSubCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->where('sub_comment_id', $sub_comment_id)->first();
            if ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 1) {
                $insertData =  DepartmentSubCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->where('sub_comment_id', $sub_comment_id)->update(['status' => 0]);
            } elseif ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 0) {
                $insertData =  DepartmentSubCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->where('sub_comment_id', $sub_comment_id)->update(['status' => 1]);
            } else {
                $insertArray = [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'comment_id' => $comment_id,
                    'sub_comment_id' => $sub_comment_id,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE
                ];
                $insertData = DepartmentSubCommentLike::insert($insertArray);
            }
            if ($insertData) {
                $post = Post::whereId($post_id)->first();
                $user = User::whereId($user_id)->first();
                $userNotify = User::whereId($post->user_id)->where('status', ACTIVE)->first();
                $notification = sendFCM('Gold Badge', $user->first_name . 'liked on your comment.', $userNotify);
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function postProfile(Request $request)
    {

        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $user_id = $request->user_id;
            $siteUrl = env('APP_URL');
            $user_data = User::with('country_data', 'state_data', 'city_data')->where('id', $user_id)->first();
            $user_data->image = $siteUrl . 'storage/uploads/user_image/' . $user_data->image;
            $posts  =   Post::with(['post_images', 'post_vote'])
                ->leftJoin('users', 'users.id', '=', 'posts.user_id')
                ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
                ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
                ->withCount('post_comment')
                ->withCount('post_like')
                ->withCount('post_share')
                ->where('user_id', $user_id)
                ->where('stay_anonymous', 0)
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
                    $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
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
                    $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                    $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                    $post->is_liked          = ($post_liked) ? 1 : 0;
                    $post->is_shared          = ($post_shared) ? 1 : 0;
                    $post->user_status       = 1;
                }
                unset($post->rating);
                unset($post->reason_id);
                unset($post->consider_rating);
                unset($post->updated_at);
            }
            return res_success('Fetch List', array('postUserData' => $user_data,  'postList' => $posts));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    public function myActivity(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $user_id = $request->user_id;
            $postLiked =  $this->postLiked($user_id)->toArray();
            $postShared = $this->postShared($user_id)->toArray();
            $postPosted =  $this->postPosted($user_id)->toArray();
            $postCommented = $this->postCommented($user_id)->toArray();
            $postCommentedLike  = $this->postCommentLike($user_id)->toArray();
            $postSubComment = $this->postSubComment($user_id)->toArray();
            $postSubCommentLike = $this->postSubCommenLike($user_id)->toArray();
            $postVoted = $this->postVoted($user_id)->toArray();
            $arr = array_merge($postLiked, $postShared, $postPosted, $postCommented, $postCommentedLike, $postSubComment, $postSubCommentLike, $postVoted);
            // Desc sort
            usort($arr, function ($time1, $time2) {
                if (strtotime($time1['created_at']) < strtotime($time2['created_at']))
                    return 1;
                else if (strtotime($time1['created_at']) > strtotime($time2['created_at']))
                    return -1;
                else
                    return 0;
            });
            $data = $this->paginateWithoutKey($request, $arr);

            // // Get current page form url e.x. &page=1
            // $currentPage = LengthAwarePaginator::resolveCurrentPage();

            // // Create a new Laravel collection from the array data
            // $productCollection = collect($arr);

            // // Define how many products we want to be visible in each page
            // $perPage = 4;

            // // Slice the collection to get the products to display in current page

            // $currentPageproducts = $productCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            // // Create our paginator and pass it to the view
            // $paginatedproducts = new LengthAwarePaginator($currentPageproducts, count($productCollection), $perPage);
            // // set url path for generted links
            // $paginatedproducts->setPath($request->url());

            return res_success(trans('messages.successFetchList'), array('postList' => $data));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function paginateWithoutKey($request, $items, $perPage = 30, $page = null, $options = [])
    {

        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $lap->setPath($request->url());

        return [
            'current_page' => $lap->currentPage(),
            'data' => $lap->values(),
            'first_page_url' => $lap->url(1),
            'from' => $lap->firstItem(),
            'last_page' => $lap->lastPage(),
            'last_page_url' => $lap->url($lap->lastPage()),
            'next_page_url' => $lap->nextPageUrl(),
            'per_page' => $lap->perPage(),
            'prev_page_url' => $lap->previousPageUrl(),
            'to' => $lap->lastItem(),
            'total' => $lap->total(),
        ];
    }

    private function postLiked($user_id)
    { // post like by user 
        $postLiked = DepartmentLike::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postLiked, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 1;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 1;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            foreach ($postLiked as $liked) {
                if ($post->id == $liked['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $liked['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->consider_rating);
            unset($post->updated_at);
        }
        return $posts;
    }
    private function  postShared($user_id)
    {
        // post shared by user
        $postShared = DepartmentShare::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postShared, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)

            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 2;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 2;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    private function postPosted($user_id)
    {
        // post posted by user
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->where('posts.user_id', $user_id)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 3;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 3;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    private function postCommented($user_id)
    {
        // post comment by user 
        $postCommented = DepartmentComment::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postCommented, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 4;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 4;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            foreach ($postCommented as $commented) {
                if ($post->id == $commented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $commented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    private function postSubComment($user_id)
    {
        //post sub commeted by user
        $postSubComment = DepartmentSubComment::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postSubComment, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 4;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 4;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            foreach ($postSubComment as $subCommented) {
                if ($post->id == $subCommented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $subCommented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    private function postSubCommenLike($user_id)
    {
        // post sub comment like by user
        $postSubCommentLike = DepartmentSubCommentLike::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postSubCommentLike, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 5;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 5;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            foreach ($postSubCommentLike as $subCommented) {
                if ($post->id == $subCommented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $subCommented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    private function postCommentLike($user_id)
    {
        // post comment Like by user 
        $postCommented = DepartmentCommentLike::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postCommented, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 5;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 5;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            foreach ($postCommented as $commented) {
                if ($post->id == $commented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $commented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    private function postVoted($user_id)
    {
        // post voted by user 
        $postVoted = DepartmentVote::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postVoted, 'post_id');
        //get all reported posts reported 
        $reportId = DepartmentReport::select('post_id')->whereIn('post_id', $postIdsArray)->get()->toArray();
        // create array of post_id from reported posts array
        $reportArray = array_column($reportId, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->whereNotIn('posts.id', $reportArray)
            ->get();
        foreach ($posts as $post) {
            //flag =1 , 1 => department , 2 => badge 
            if ($post->flag == 1) {
                // get department w.r.t given department id
                $departmentPostData = Post::where('department_id', $post->department_id)->get();
                //get department w.r.t given department id with consider rating == 1
                $departmentAvgRating = Post::where('department_id', $post->department_id)->where('consider_rating', 1)->get();
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $user_followed_department = UserDepartmentFollow::where('user_id', $user_id)->where('department_id', $post->department_id)->first();
                $post->total_reviews    =   $departmentPostData->count();
                $post->avg_rating       =  ($departmentAvgRating->avg('rating')) ? number_format($departmentAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   null;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 6;
                $post->is_followed_by_user = ($user_followed_department) ? $user_followed_department->status : 0;
            } else if ($post->flag == 2) {
                $post_liked = DepartmentLike::where('user_id', $user_id)->where('post_id', $post->id)->first();
                $post_shared = DepartmentShare::where('user_id', $user_id)->where('post_id', $post->id)->first();
                // get department w.r.t given badge id
                $badgePostData = Post::where('badge_id', $post->badge_id)->get();
                //get department w.r.t given badge id with consider rating == 1
                $badgePostAvgRating = Post::where('badge_id', $post->badge_id)->where('consider_rating', 1)->get();
                $user_followed_badge = UserDepartmentBadgeFollow::where('user_id', $user_id)->where('badge_id', $post->badge_id)->first();
                $post->total_reviews    =   $badgePostData->count();
                $post->avg_rating       =   ($badgePostAvgRating->avg('rating')) ? number_format($badgePostAvgRating->avg('rating'), 1) : 0;
                $post->badge_name       =   DepartmentBadge::find($post->badge_id)->badge_number;
                $post->is_liked          = ($post_liked) ? 1 : 0;
                $post->is_shared          = ($post_shared) ? 1 : 0;
                $post->user_status       = 6;
                $post->is_followed_by_user = ($user_followed_badge) ? $user_followed_badge->status : 0;
            }
            foreach ($postVoted as $vote) {
                if ($post->id == $vote['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $vote['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
            unset($post->consider_rating);
        }
        return $posts;
    }
    public function delete_post(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [

                    'post_id' => 'required'

                ]
            );
            /**
             * Check input parameter validation
             */

            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }

            $post = Post::where('id', $request->post_id)->first();
            if (!$post) {
                throw new Exception('post does not exists.', NOT_EXISTS);
            }

            $postImage = PostImage::where('post_id', $request->post_id)->get();
            // unlink all post images
            foreach ($postImage as $key => $value) {

                Storage::disk('public')->delete('uploads/post_department_image/' . $value->image);
            }

            DepartmentLike::where('post_id', $request->post_id)->delete();
            DepartmentShare::where('post_id', $request->post_id)->delete();
            DepartmentCommentLike::where('post_id', $request->post_id)->delete();
            DepartmentReport::where('post_id', $request->post_id)->delete();
            DepartmentSubCommentLike::where('post_id', $request->post_id)->delete();
            PostImage::where('post_id', $request->post_id)->delete();
            DepartmentVote::where('post_id', $request->post_id)->delete();
            DepartmentSubComment::where('post_id', $request->post_id)->delete();
            DepartmentComment::where('post_id', $request->post_id)->delete();

            $deletePost = Post::where('id', $request->post_id)->delete();
            return res_success('Your post is deleted successfully.');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
