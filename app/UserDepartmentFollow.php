<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

class UserDepartmentFollow extends Model
{
    public function post_data()
    {
        return $this->belongsTo('App\Post',  'department_id', 'department_id');
    }
    public function post_reviews()
    {
        return $this->hasMany('App\Post', 'department_id');
    }
    public function departments()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }
    public function post_vote()
    {
        $siteUrl = env('APP_URL');

        return $this->hasMany('App\DepartmentVote', 'post_id', 'post_id')->select(
            'department_votes.id as vote_id',
            'department_votes.rating',
            'user_id',
            'post_id',
            'users.user_name',
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image")
        )
            ->leftjoin("users", function ($join) {
                $join->on('department_votes.user_id', '=', 'users.id');
            });
    }
    public function post_images()
    {
        $siteUrl = env('APP_URL');
        return $this->hasMany('App\PostImage', 'post_id', 'post_id')->select('id', 'post_id', DB::raw("CONCAT('$siteUrl','storage/uploads/post_department_image/', image) as post_department_image"), 'media_type');
    }
    public  static function getPostDepartmentData($user_id)
    {
        $siteUrl = env('APP_URL');
        $query = Post::with('departments', 'badges', 'users')->orderBy('created_at', 'desc')->get();
        foreach ($query as $value) {
            $is_liked = DepartmentLike::where('post_id', $value->id)->where('status' ,1)->where('user_id', $user_id)->first();
            $like_count = DepartmentLike::where('post_id', $value->id)->where('status' ,1)->count();
            $share_count = DepartmentShare::where('post_id', $value->id)->count();
            $comment_count  = DepartmentComment::where('post_id', $value->id)->count();
            $value['department_name'] = $value->departments->department_name;
            $value['department_image'] = $value->departments->image;
            $value['is_liked'] = ($is_liked) ? 1 : 0;
            $value['like_count'] = $like_count;
            $value['share_count'] = $share_count;
            $value['comment_count'] = $comment_count;
        }
        // $query = self::query()->where('user_id', $user_id)->whereHas('post_reviews')->with('post_reviews.departments', 'post_reviews.badges', 'post_reviews.users')->get();
        return $query;
    }
    public  static function getPostDepartmentDataLike($user_id)
    {
        $siteUrl = env('APP_URL');
        $query = Post::query()->select(
            'posts.user_id',
            'posts.id as post_id',
            'users.user_name',
            'departments.department_name',
            'posts.created_at',
            'posts.comment as post_content',
            'posts.flag',
            'posts.department_id',
            'posts.stay_anonymous',
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
            DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image"),
            DB::raw('COUNT(department_likes.post_id) as like_count'),
            DB::raw('COUNT(department_shares.post_id) as share_count'),
            DB::raw('COUNT(department_comments.post_id) as comment_count')
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })
            ->leftjoin("users", function ($join) {
                $join->on('posts.user_id', '=', 'users.id');
            })
            ->leftjoin("department_likes", function ($join) {
                $join->on('department_likes.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_shares", function ($join) {
                $join->on('department_shares.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_comments", function ($join) {
                $join->on('department_comments.post_id', '=', 'posts.id');
            })
            ->where('flag', 1)->with('post_images')->with('post_vote')->groupBy('posts.id')->orderBy('like_count', 'DESC')->paginate(ITEM_PER_PAGE);
        return $query;
    }
    public  static function getPostDepartmentDataShare($user_id)
    {
        $siteUrl = env('APP_URL');
        $query = Post::query()->select(
            'posts.user_id',
            'posts.id as post_id',
            'users.user_name',
            'departments.department_name',
            'posts.created_at',
            'posts.comment as post_content',
            'posts.flag',
            'posts.department_id',
            'posts.stay_anonymous',
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
            DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image"),
            DB::raw('COUNT(department_likes.post_id) as like_count'),
            DB::raw('COUNT(department_shares.post_id) as share_count'),
            DB::raw('COUNT(department_comments.post_id) as comment_count')
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })

            ->leftjoin("users", function ($join) {
                $join->on('posts.user_id', '=', 'users.id');
            })
            ->leftjoin("department_likes", function ($join) {
                $join->on('department_likes.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_shares", function ($join) {
                $join->on('department_shares.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_comments", function ($join) {
                $join->on('department_comments.post_id', '=', 'posts.id');
            })

            ->where('flag', 1)->with('post_images')->with('post_vote')->groupBy('posts.id')->orderBy('share_count', 'DESC')->paginate(ITEM_PER_PAGE);
        return $query;
    }
    public  static function getPostDepartmentDataGuest($user_id)
    {
        $siteUrl = env('APP_URL');
        $query = Post::query()->select(
            'posts.user_id',
            'posts.id as post_id',
            'users.user_name',
            'departments.department_name',
            'posts.created_at',
            'posts.comment as post_content',
            'posts.flag',
            'posts.department_id',
            'posts.stay_anonymous',
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
            DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image"),
            DB::raw('COUNT(department_likes.post_id) as like_count'),
            DB::raw('COUNT(department_shares.post_id) as share_count'),
            DB::raw('COUNT(department_comments.post_id) as comment_count')
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })

            ->leftjoin("users", function ($join) {
                $join->on('posts.user_id', '=', 'users.id');
            })
            ->leftjoin("department_likes", function ($join) {
                $join->on('department_likes.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_shares", function ($join) {
                $join->on('department_shares.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_comments", function ($join) {
                $join->on('department_comments.post_id', '=', 'posts.id');
            })

            ->where('flag', 1)->with('post_images')->with('post_vote')->groupBy('posts.id')->latest('posts.created_at')->paginate(ITEM_PER_PAGE);
        return $query;
    }
}
