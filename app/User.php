<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $fillable = [
        'first_name', 'last_name', 'email', 'mobile_country_code', 'mobil_no', 'user_name', 'dob', 'image', 'gender', 'ethnicity', 'country_id', 'state_id', 'city_id', 'status', 'chat_status'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function country_data()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
    public function state_data()
    {
        return $this->belongsTo('App\CountryState', 'state_id');
    }
    public function city_data()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
    public function getdata_table($order_by, $offset, $limit_t, $fromdate, $todate, $status_id, $country_id, $state_id, $search)
    {
        $query = self::query()->orderBy('created_at', 'asc');
        if (!empty($search)) {
            $query->where('first_name', 'like', '%' . $search . '%');
            $query->orwhere('mobil_no', 'like', '%' . $search . '%');
            $query->orwhere('email', 'like', '%' . $search . '%');
            $query->orwhere('user_name', 'like', '%' . $search . '%');
        }
        if (!empty($fromdate) &&  !empty($todate)) {
            $fromdate =  date('Y-m-d', strtotime($fromdate));
            $todate =  date('Y-m-d', strtotime($todate));
            $query->Where(function ($q) use ($fromdate, $todate) {
                $q->wheredate('created_at', '>=', $fromdate);
                $q->wheredate('created_at', '<=', $todate);
            });
        }
        if (!empty($status_id)) {
            $query->Where(function ($q) use ($status_id) {
                $q->where('status', $status_id);
            });
        }
        if (!empty($country_id)) {
            $query->Where(function ($q) use ($country_id) {
                $q->where('country_id', $country_id);
            });
        }
        if (!empty($state_id)) {
            $query->Where(function ($q) use ($state_id) {
                $q->where('state_id', $state_id);
            });
        }
        $query->skip($offset);
        $query->take($limit_t);
        $data = $query->get(); //->toArray();
        // $data = $query->get()->toArray();
        // echo"<pre>";print_r($data);  die;
        foreach ($data as $key => $value) {
            $count  = Post::where('user_id', $value->id)->count();
            $value['total_reviews'] = $count;
        }
        return $data;
    }
    public function getdata_count($order_by, $fromdate, $todate, $status_id, $country_id, $state_id, $search)
    {
        $query = self::query()->orderBy('created_at', 'asc');
        if (!empty($search)) {
            $query->where('first_name', 'like', '%' . $search . '%');
            $query->orwhere('mobil_no', 'like', '%' . $search . '%');
            $query->orwhere('email', 'like', '%' . $search . '%');
            $query->orwhere('user_name', 'like', '%' . $search . '%');
        }
        if (!empty($fromdate) &&  !empty($todate)) {
            $fromdate =  date('Y-m-d', strtotime($fromdate));
            $todate =  date('Y-m-d', strtotime($todate));
            $query->Where(function ($q) use ($fromdate, $todate) {
                $q->wheredate('created_at', '>=', $fromdate);
                $q->wheredate('created_at', '<=', $todate);
            });
        }
        if (!empty($status_id)) {
            $query->Where(function ($q) use ($status_id) {
                $q->where('status', $status_id);
            });
        }
        if (!empty($country_id)) {
            $query->Where(function ($q) use ($country_id) {
                $q->where('country_id', $country_id);
            });
        }
        if (!empty($state_id)) {
            $query->Where(function ($q) use ($state_id) {
                $q->where('state_id', $state_id);
            });
        }

        $data = $query->get(); //->toArray();
        // $data = $query->get()->toArray();
        // echo"<pre>";print_r($data);  die;
        foreach ($data as $key => $value) {
            $count  = Post::where('user_id', $value->id)->count();
            $value['total_reviews'] = $count;
        }
        return count($data);
    }
    public static function getPostDepartment($user_id, $search, $offset, $limit_t)
    {
        $query = Post::select(
            'posts.id as post_id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'departments.department_name'
            // 'departments.image',
            // 'departments.created_at',
            // 'reason_id',
            // 'posts.created_at',
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })->where('posts.user_id', $user_id)->where('posts.flag', 1);
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
            });
        }
        $query->skip($offset);
        $query->take($limit_t);
        $query = $query->latest('posts.created_at')->get();

        return $query;
    }

    public static function getPostDepartmentCount($user_id, $search)
    {
        $query = Post::select(
            'posts.id as post_id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'departments.department_name'
            // 'departments.image',
            // 'departments.created_at',
            // 'reason_id',
            // 'posts.created_at',
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })->where('posts.user_id', $user_id)->where('posts.flag', 1);
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
            });
        }

        $query = $query->latest('posts.created_at')->get();

        return count($query);
    }
    public static function getPostBadge($user_id, $search, $offset, $limit_t)
    {
        $query = Post::select(
            'posts.id as post_id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'departments.department_name',
            // 'departments.image',
            // 'departments.created_at',
            // 'reason_id',
            // 'posts.created_at',
            'posts.badge_id',
            'department_badges.badge_number'
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })
            ->leftjoin("department_badges", function ($join) {
                $join->on('posts.badge_id', '=', 'department_badges.id');
            })
            ->where('posts.user_id', $user_id)->where('posts.flag', 2);
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
                $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
            });
        }

        $query->skip($offset);
        $query->take($limit_t);
        $query = $query->latest('posts.created_at')->get();

        return $query;
    }
    public static function getPostBadgeCount($user_id, $search)
    {
        $query = Post::select(
            'posts.id as post_id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'departments.department_name',
            // 'departments.image',
            // 'departments.created_at',
            // 'reason_id',
            // 'posts.created_at',
            'posts.badge_id',
            'department_badges.badge_number'
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })
            ->leftjoin("department_badges", function ($join) {
                $join->on('posts.badge_id', '=', 'department_badges.id');
            })
            ->where('posts.user_id', $user_id)->where('posts.flag', 2);
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
                $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
            });
        }
        $query = $query->latest('posts.created_at')->get();

        return count($query);
    }
    public static function getPost($user_id, $offset, $limit_t)
    {
        $query = Post::select(
            'posts.id as post_id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'departments.department_name',
            'departments.image',
            'departments.created_at',
            'reason_id',
            'posts.badge_id',
            'posts.created_at',
            'department_badges.badge_number'
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })->leftjoin("department_badges", function ($join) {
                $join->on('posts.badge_id', '=', 'department_badges.id');
            })
            ->where('user_id', $user_id);


        $query->skip($offset);
        $query->take($limit_t);
        $query = $query->latest('posts.created_at')->get();
        $arr = [];
        $post_data = [];
        foreach ($query as $key => $value) {
            $likeCount =  DepartmentLike::where('post_id', $value->post_id)->where('status', 1)->count();
            $shareCount = DepartmentShare::where('post_id', $value->post_id)->count();
            $commentCount  = DepartmentComment::where('post_id', $value->post_id)->count();
            $reportCount = DepartmentReport::where('post_id', $value->post_id)->count();
            $value['department_like'] = $likeCount;
            $value['department_share'] = $shareCount;
            $value['department_comment'] = $commentCount;
            $value['department_report'] = $reportCount;
            array_push($post_data, $value);
            // if ($value->badge_id == null) {
            //    array_push($arr, $value->badge_id);
            //    array_push($post_data, $value);
            // } else {
            //    if (!in_array($value->badge_id, $arr)) {
            //       array_push($arr, $value->badge_id);
            //       array_push($post_data, $value);
            //       $rating = Post::where('department_id', $value->department_id)->where('user_id', $value->user_id)->where('flag', 2)->where('badge_id', $value->badge_id)
            //          ->avg('rating');
            //       $value['rating'] = $rating;
            //    }
            // }
        }
        return $post_data;
    }
    public static function getPostCount($user_id)
    {
        $query = Post::select(
            'posts.id as post_id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'departments.department_name',
            'departments.image',
            'departments.created_at',
            'reason_id',
            'posts.badge_id',
            'posts.created_at',
            'department_badges.badge_number'
        )
            ->leftjoin("departments", function ($join) {
                $join->on('posts.department_id', '=', 'departments.id');
            })->leftjoin("department_badges", function ($join) {
                $join->on('posts.badge_id', '=', 'department_badges.id');
            })
            ->where('user_id', $user_id);

        $query = $query->latest('posts.created_at')->get();
        $arr = [];
        $post_data = [];
        foreach ($query as $key => $value) {
            array_push($post_data, $value);

            // if ($value->badge_id == null) {

            //    array_push($arr, $value->badge_id);
            //    array_push($post_data, $value);
            // } else {
            //    if (!in_array($value->badge_id, $arr)) {
            //       array_push($arr, $value->badge_id);
            //       array_push($post_data, $value);

            //       $rating = Post::where('department_id', $value->department_id)->where('user_id', $value->user_id)->where('flag', 2)->where('badge_id', $value->badge_id)
            //          ->avg('rating');
            //    }
            // }
        }
        return count($post_data);
    }
    public static function getPostDepartmentFollowing($user_id, $search, $offset, $limit_t)
    {
        $query = UserDepartmentFollow::select(

            'user_department_follows.user_id',
            'user_department_follows.department_id',
            'departments.department_name'
        )
            ->leftjoin("departments", function ($join) {
                $join->on('user_department_follows.department_id', '=', 'departments.id');
            })
            ->where('user_department_follows.user_id', $user_id);
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
            });
        }
        $query->skip($offset);
        $query->take($limit_t);
        $query = $query->get();
        foreach ($query as  $post) {
            $post_reviews = Post::where('department_id', $post->department_id)->where('flag', 1)->first();
            $total_reviews = Post::where('department_id', $post->department_id)->count();
            $rating = Post::where('department_id', $post->department_id)->avg('rating');
            $post['post_id'] = ($post_reviews) ? $post_reviews->id : 0;
            $post['total_reviews'] = $total_reviews;
            $post['rating'] = ($rating) ? $rating : 0;
        }

        return $query;
    }
    public static function getPostDepartmentFollowingCount($user_id, $search)
    {
        $query = UserDepartmentFollow::select(

            'user_department_follows.user_id',
            'user_department_follows.department_id',
            'departments.department_name'
        )
            ->leftjoin("departments", function ($join) {
                $join->on('user_department_follows.department_id', '=', 'departments.id');
            })
            ->where('user_department_follows.user_id', $user_id);
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
            });
        }

        $query = $query->get();
        foreach ($query as  $post) {
            $post_reviews = Post::where('department_id', $post->department_id)->where('flag', 1)->first();
            $total_reviews = Post::where('department_id', $post->department_id)->count();
            $rating = Post::where('department_id', $post->department_id)->avg('rating');
            $post['post_id'] = ($post_reviews) ? $post_reviews->id : 0;
            $post['total_reviews'] = $total_reviews;
            $post['rating'] = ($rating) ? $rating : 0;
        }

        return count($query);
    }
    public static function getPostBadgeFollowing($user_id, $search, $offset, $limit_t)
    {
        $query = UserDepartmentBadgeFollow::select(
            'user_department_badge_follows.user_id',
            'departments.department_name',
            'user_department_badge_follows.badge_id',
            'department_badges.badge_number'
        )
            ->leftjoin("department_badges", function ($join) {
                $join->on('user_department_badge_follows.badge_id', '=', 'department_badges.id');
            })
            ->leftjoin("departments", function ($join) {
                $join->on('department_badges.department_id', '=', 'departments.id');
            })
            ->where('user_department_badge_follows.user_id', $user_id)
            ->groupBy('departments.id');
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
                $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
            });
        }
        $query->skip($offset);
        $query->take($limit_t);
        $query = $query->get();
        foreach ($query as  $post) {
            $post_reviews = Post::where('badge_id', $post->badge_id)->where('flag', 2)->first();
            $total_reviews = Post::where('badge_id', $post->badge_id)->count();
            $rating = Post::where('badge_id', $post->badge_id)->avg('rating');
            $post['post_id'] = ($post_reviews) ? $post_reviews->id : 0;
            $post['total_reviews'] = $total_reviews;
            $post['rating'] = ($rating) ? $rating : 0;
        }
        return $query;
    }
    public static function getPostBadgeFollowingCount($user_id, $search)
    {
        $query = UserDepartmentBadgeFollow::select(
            'user_department_badge_follows.user_id',
            'departments.department_name',
            'user_department_badge_follows.badge_id',
            'department_badges.badge_number'
        )
            ->leftjoin("department_badges", function ($join) {
                $join->on('user_department_badge_follows.badge_id', '=', 'department_badges.id');
            })
            ->leftjoin("departments", function ($join) {
                $join->on('department_badges.department_id', '=', 'departments.id');
            })
            ->where('user_department_badge_follows.user_id', $user_id)
            ->groupBy('departments.id');
        if ($search) {
            $query->Where(function ($q) use ($search) {
                $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
                $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
            });
        }

        $query = $query->get();
        foreach ($query as  $post) {
            $post_reviews = Post::where('badge_id', $post->badge_id)->where('flag', 2)->first();
            $total_reviews = Post::where('badge_id', $post->badge_id)->count();
            $rating = Post::where('badge_id', $post->badge_id)->avg('rating');
            $post['post_id'] = ($post_reviews) ? $post_reviews->id : 0;
            $post['total_reviews'] = $total_reviews;
            $post['rating'] = ($rating) ? $rating : 0;
        }
        return count($query);
    }
}
