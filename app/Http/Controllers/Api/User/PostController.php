<?php

namespace App\Http\Controllers\Api\User;

use App\Post;
use App\User;
use Exception;
use App\DepartmentLike;
use App\DepartmentBadge;
use App\DepartmentComment;
use App\DepartmentShare;
use Illuminate\Http\Request;
use App\UserDepartmentFollow;
use App\DepartmentCommentLike;
use App\DepartmentSubComment;
use App\DepartmentSubCommentLike;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function postProfile(Request $request)
    {
        $user_id = $request->user_id;
        $siteUrl = env('APP_URL');
        $user_data = User::with('country_data', 'state_data', 'city_data')->where('id', $user_id)->first();
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
        return res_success('Fetch List', array('postUserData' => $user_data,  'postList' => $posts));
    }

    public function myAcivity(Request $request)
    {
        $user_id = $request->user_id;
        $postLiked =  $this->postLiked($user_id)->toArray();
        $postShared = $this->postShared($user_id)->toArray();
        $postPosted =  $this->postPosted($user_id)->toArray();
        $postCommented = $this->postCommented($user_id)->toArray();
        $postCommentedLike  = $this->postCommentLike($user_id)->toArray();
        $postSubComment = $this->postSubComment($user_id)->toArray();
        $postSubCommentLike = $this->postSubCommenLike($user_id)->toArray();
        $arr = array_merge($postLiked, $postShared, $postPosted, $postCommented, $postCommentedLike, $postSubComment, $postSubCommentLike);
        // Desc sort
        usort($arr, function ($time1, $time2) {
            if (strtotime($time1['created_at']) < strtotime($time2['created_at']))
                return 1;
            else if (strtotime($time1['created_at']) > strtotime($time2['created_at']))
                return -1;
            else
                return 0;
        });
        return res_success('Fetch List', array('postList' => $arr));
    }
    private function postLiked($user_id)
    { // post like by user 
        $postLiked = DepartmentLike::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postLiked, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->get();
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
            foreach ($postLiked as $liked) {
                if ($post->id == $liked['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $liked['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
        }
        return $posts;
    }
    private function  postShared($user_id)
    {
        // post shared by user
        $postShared = DepartmentShare::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postShared, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->get();
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
            foreach ($postShared as $shared) {
                if ($post->id == $shared['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $shared['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
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
        return $posts;
    }
    private function postCommented($user_id)
    {
        // post comment by user 
        $postCommented = DepartmentComment::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postCommented, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->get();
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
            foreach ($postCommented as $commented) {
                if ($post->id == $commented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $commented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
        }
        return $posts;
    }
    private function postSubComment($user_id)
    {
        //post sub commeted by user
        $postSubComment = DepartmentSubComment::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postSubComment, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->get();
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
            foreach ($postSubComment as $subCommented) {
                if ($post->id == $subCommented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $subCommented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
        }
        return $posts;
    }
    private function postSubCommenLike($user_id)
    {
        // post sub comment like by user
        $postSubCommentLike = DepartmentSubCommentLike::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postSubCommentLike, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->get();
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
            foreach ($postSubCommentLike as $subCommented) {
                if ($post->id == $subCommented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $subCommented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
        }
        return $posts;
    }
    private function postCommentLike($user_id)
    {
        // post comment Like by user 
        $postCommented = DepartmentCommentLike::where('user_id', $user_id)->get()->toArray();
        $postIdsArray     =   array_column($postCommented, 'post_id');
        $siteUrl = env('APP_URL');
        $posts  = Post::with(['post_images', 'post_vote'])
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('departments', 'departments.id', '=', 'posts.department_id')
            ->select('posts.*', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'departments.department_name', DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image ) as department_image"))
            ->withCount('post_comment')
            ->withCount('post_like')
            ->withCount('post_share')
            ->whereIn('posts.id', $postIdsArray)
            ->get();
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
            foreach ($postCommented as $commented) {
                if ($post->id == $commented['post_id']) {
                    unset($post->created_at);
                    $post->created_at = $commented['created_at'];
                }
            }
            unset($post->rating);
            unset($post->reason_id);
            unset($post->updated_at);
        }
        return $posts;
    }
}
