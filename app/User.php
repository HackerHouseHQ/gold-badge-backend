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
      'first_name', 'last_name', 'email', 'mobile_country_code', 'mobil_no', 'user_name', 'dob', 'image', 'gender', 'ethnicity', 'country_id', 'state_id', 'city_id', 'status'
   ];

   protected $casts = [
      'email_verified_at' => 'datetime',
   ];
   public function getdata_table($order_by, $offset, $limit_t, $fromdate, $todate, $status_id, $country_id, $state_id)
   {
      $query = self::query()->orderBy('created_at', 'asc');
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
   public function getdata_count($order_by, $fromdate, $todate, $status_id, $country_id, $state_id)
   {
      $query = self::query()->orderBy('created_at', 'asc');
      if (!empty($fromdate) &&  !empty($todate)) {
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

      $data = $query->get();
      $total = $data->count();
      return $total;
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
         $likeCount =  DepartmentLike::where('post_id', $value->post_id)->count();
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
         DB::raw('COUNT(posts.department_id) as total_reviews')
         // DB::raw('AVG(posts.rating) as rating')
      )
         ->leftjoin("departments", function ($join) {
            $join->on('user_department_follows.department_id', '=', 'departments.id');
         })
         ->leftjoin("posts", function ($join) {
            $join->on('user_department_follows.department_id', '=', 'posts.department_id');
         })
         ->groupBy('departments.id')
         ->where('user_department_follows.user_id', $user_id)->where('posts.flag', 1);
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
   public static function getPostDepartmentFollowingCount($user_id, $search)
   {
      $query = UserDepartmentFollow::select(
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
         DB::raw('COUNT(posts.department_id) as total_reviews')
         // DB::raw('AVG(posts.rating) as rating')
      )
         ->leftjoin("departments", function ($join) {
            $join->on('user_department_follows.department_id', '=', 'departments.id');
         })
         ->leftjoin("posts", function ($join) {
            $join->on('user_department_follows.department_id', '=', 'posts.department_id');
         })
         ->groupBy('departments.id')
         ->where('user_department_follows.user_id', $user_id)->where('posts.flag', 1);
      if ($search) {
         $query->Where(function ($q) use ($search) {
            $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
         });
      }

      $query = $query->latest('posts.created_at')->get();

      return count($query);
   }
   public static function getPostBadgeFollowing($user_id, $search, $offset, $limit_t)
   {
      $query = UserDepartmentBadgeFollow::select(
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
         'department_badges.badge_number',
         DB::raw('COUNT(posts.badge_id) as total_reviews')

      )
         ->leftjoin("posts", function ($join) {
            $join->on('user_department_badge_follows.badge_id', '=', 'posts.badge_id');
         })
         ->leftjoin("departments", function ($join) {
            $join->on('posts.department_id', '=', 'departments.id');
         })
         ->leftjoin("department_badges", function ($join) {
            $join->on('posts.badge_id', '=', 'department_badges.id');
         })
         ->where('user_department_badge_follows.user_id', $user_id)->where('posts.flag', 2)
         ->groupBy('departments.id');
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
   public static function getPostBadgeFollowingCount($user_id, $search)
   {
      $query = UserDepartmentBadgeFollow::select(
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
         'department_badges.badge_number',
         DB::raw('COUNT(posts.badge_id) as total_reviews')
      )
         ->leftjoin("posts", function ($join) {
            $join->on('user_department_badge_follows.badge_id', '=', 'posts.badge_id');
         })
         ->leftjoin("departments", function ($join) {
            $join->on('posts.department_id', '=', 'departments.id');
         })
         ->leftjoin("department_badges", function ($join) {
            $join->on('posts.badge_id', '=', 'department_badges.id');
         })
         ->where('user_department_badge_follows.user_id', $user_id)->where('posts.flag', 2)
         ->groupBy('departments.id');
      if ($search) {
         $query->Where(function ($q) use ($search) {
            $q->orwhere('departments.department_name', 'like', '%' . $search . '%');
            $q->orwhere('department_badges.badge_number', 'like', '%' . $search . '%');
         });
      }
      $query = $query->latest('posts.created_at')->get();

      return count($query);
   }
}
