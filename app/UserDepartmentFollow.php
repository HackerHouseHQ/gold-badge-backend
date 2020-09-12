<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserDepartmentFollow extends Model
{
    public function post_data()
    {
        return $this->belongsTo('App\Post',  'department_id', 'department_id');
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
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
        )
            ->leftjoin("users", function ($join) {
                $join->on('department_votes.user_id', '=', 'users.id');
            });
    }
    public function post_image()
    {
        $siteUrl = env('APP_URL');
        return $this->hasMany('App\PostImage', 'post_id', 'post_id')->select('id', 'post_id', DB::raw("CONCAT('$siteUrl','storage/uploads/post_department_image/', image) as post_department_image"));
    }
    public  static function getPostDepartmentData($user_id)
    {
        $siteUrl = env('APP_URL');
        $query = self::query()->select(
            'posts.user_id',
            'posts.id as post_id',
            'users.user_name',
            'departments.department_name',
            'posts.created_at',
            'posts.comment as post_content',
            'posts.flag',
            'user_department_follows.department_id',
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
            DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image"),
            DB::raw('COUNT(department_likes.post_id) as like_count'),
            DB::raw('COUNT(department_shares.post_id) as share_count'),
            DB::raw('COUNT(department_comments.post_id) as comment_count'),

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
            ->leftjoin("department_likes", function ($join) {
                $join->on('department_likes.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_shares", function ($join) {
                $join->on('department_shares.post_id', '=', 'posts.id');
            })
            ->leftjoin("department_comments", function ($join) {
                $join->on('department_comments.post_id', '=', 'posts.id');
            })
            ->where('user_department_follows.user_id', $user_id)
            ->where('flag', 1)->with('post_image')->with('post_vote')->groupBy('posts.id')->latest('posts.created_at')->paginate(5);
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
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
            DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image"),
            DB::raw('COUNT(department_likes.post_id) as like_count'),
            DB::raw('COUNT(department_shares.post_id) as share_count'),
            DB::raw('COUNT(department_comments.post_id) as comment_count'),



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
            ->where('flag', 1)->with('post_image')->with('post_vote')->groupBy('posts.id')->orderBy('like_count', 'DESC')->paginate(5);
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
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
            DB::raw("CONCAT('$siteUrl','storage/departname/', departments.image) as department_image"),
            DB::raw('COUNT(department_likes.post_id) as like_count'),
            DB::raw('COUNT(department_shares.post_id) as share_count'),
            DB::raw('COUNT(department_comments.post_id) as comment_count'),
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

            ->where('flag', 1)->with('post_image')->with('post_vote')->groupBy('posts.id')->orderBy('share_count', 'DESC')->paginate(5);
        return $query;
    }
}
