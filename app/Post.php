<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

   protected $fillable = ['country_id', 'state_id', 'city_id', 'department_name', 'image', 'status', 'id', 'user_id'];

   public function post_vote()
   {
      $siteUrl = env('APP_URL');

      return $this->hasMany('App\DepartmentVote', 'post_id')->select(
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

   public function users()
   {
      return $this->belongsTo('App\User', 'user_id');
   }
   public function departments()
   {
      return $this->belongsTo('App\Department', 'department_id');
   }
   public function badges()
   {
      return $this->belongsTo('App\DepartmentBadge', 'badge_id');
   }
   public function departmentBadge()
   {
      return $this->belongsTo('App\DepartmentBadge', 'department_id');
   }
   public function getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id)
   {
      // DB::enableQueryLog();
      if ($badge_id) {
         $query = self::query()->select('id', 'user_id', 'department_id', DB::raw('avg(rating) as rating'), 'flag', 'created_at')
            // ->with('users')
            ->groupBy('user_id', 'flag')->latest('created_at')->where('flag', 2);
      } else {
         $query = self::query()->select('id', 'user_id', 'department_id', DB::raw('avg(rating) as rating'), 'flag', 'created_at')
            // ->with('users')
            ->groupBy('user_id', 'flag')
            ->latest('created_at');
      }
      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $q->wheredate('created_at', '>=', $fromdate);
            $q->wheredate('created_at', '<=', $todate);
         });
      }
      if (!empty($search)) {

         $query->whereHas('users', function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%');
            $q->orwhere('last_name', 'like', '%' . $search . '%');
            $q->orwhere('user_name', 'like', '%' . $search . '%');
         });
      }
      if (!empty($status_id)) {
         $query->whereHas('users', function ($q) use ($status_id) {
            $q->where('status', $status_id);
         });
      }
      if (!empty($department_id)) {

         $query->whereHas('departments', function ($q) use ($department_id) {
            $q->where('id', $department_id);
         });
      }
      if (!empty($badge_id)) {
         $query->whereHas('departmentBadge', function ($q) use ($badge_id) {
            $q->where('id', $badge_id);
         });
      }
      if (!empty($country_id)) {

         $query->whereHas('departments', function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
         });
      }
      if (!empty($state_id)) {
         $query->whereHas('departments', function ($q) use ($state_id) {
            $q->where('state_id', $state_id);
         });
      }
      if (!empty($city_id)) {
         $query->whereHas('departments', function ($q) use ($city_id) {
            $q->where('city_id', $city_id);
         });
      }
      $query->skip($offset);
      $query->take($limit_t);
      $data = $query->get(); //->toArray();
      // $data = $query->get()->toArray();
      // $data = DB::getQueryLog();
      // echo"<pre>";print_r($data);  die;
      return $data;
   }
   public function getdata_count($status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id)
   {
      if ($badge_id) {
         $query = self::query()->select('id', 'user_id', 'department_id', DB::raw('avg(rating) as rating'), 'flag', 'created_at')
            // ->with('users')
            ->groupBy('user_id', 'flag')->latest('created_at')->where('flag', 2);
      } else {
         $query = self::query()->select('id', 'user_id', 'department_id', DB::raw('avg(rating) as rating'), 'flag', 'created_at')
            // ->with('users')
            ->groupBy('user_id', 'flag')
            ->latest('created_at');
      }
      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $q->wheredate('created_at', '>=', $fromdate);
            $q->wheredate('created_at', '<=', $todate);
         });
      }
      if (!empty($search)) {

         $query->whereHas('users', function ($q) use ($search) {
            $q->where('first_name', 'like', '%' . $search . '%');
            $q->orwhere('last_name', 'like', '%' . $search . '%');
            $q->orwhere('user_name', 'like', '%' . $search . '%');
         });
      }
      if (!empty($status_id)) {
         $query->whereHas('users', function ($q) use ($status_id) {
            $q->where('status', $status_id);
         });
      }
      if (!empty($department_id)) {

         $query->whereHas('departments', function ($q) use ($department_id) {
            $q->where('id', $department_id);
         });
      }
      if (!empty($badge_id)) {
         $query->whereHas('departmentBadge', function ($q) use ($badge_id) {
            $q->where('id', $badge_id);
         });
      }
      if (!empty($country_id)) {

         $query->whereHas('departments', function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
         });
      }
      if (!empty($state_id)) {
         $query->whereHas('departments', function ($q) use ($state_id) {
            $q->where('state_id', $state_id);
         });
      }
      if (!empty($city_id)) {
         $query->whereHas('departments', function ($q) use ($city_id) {
            $q->where('city_id', $city_id);
         });
      }
      $data = $query->get();
      $total = $data->count();
      return $total;
   }

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
   public function post_image()
   {
      return $this->hasMany('App\PostImage', 'post_id');
   }

   public function post_images()
   {
      $siteUrl = env('APP_URL');

      return $this->hasMany('App\PostImage', 'post_id')->select('id', 'post_id', DB::raw("CONCAT('$siteUrl','storage/uploads/post_department_image/', image) as post_department_image"), 'media_type');
   }
   public static function getPost($search,  $department_id, $badge_id, $fromdate, $todate, $order_by, $limit_t, $offset, $user_id)
   {
      $query = self::query()->select(
         'posts.id as post_id',
         'posts.user_id',
         'posts.department_id',
         'posts.badge_id',
         'posts.rating',
         'department_badges.badge_number',
         'posts.comment',
         'posts.flag',
         'departments.department_name',
         'departments.image',
         'departments.created_at',
         'reason_id',
         'posts.created_at'
      )
         ->leftjoin("departments", function ($join) {
            $join->on('posts.department_id', '=', 'departments.id');
         })
         ->leftjoin("department_badges", function ($join) {
            $join->on('posts.badge_id', '=', 'department_badges.id');
         })
         ->where('user_id', $user_id);
      if ($search) {
         $query->orwhere('department_name', 'like', '%' . $search . '%');
      }
      if ($department_id) {
         $query
            ->where('posts.department_id',  $department_id);
      }
      if ($badge_id) {
         $query->where('badge_id', 'like', $badge_id);
      }
      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $q->wheredate('posts.created_at', '>=', $fromdate);
            $q->wheredate('posts.created_at', '<=', $todate);
         });
      }
      $query->with('post_images');
      $query->skip($offset);
      $query->take($limit_t);
      $query = $query->latest('posts.created_at')->get();
      $arr = [];
      $post_data = [];
      // foreach ($query as $key => $value) {
      //    if ($value->badge_id == null) {
      //       array_push($arr, $value->badge_id);
      //       array_push($post_data, $value);
      //    } else {
      //       if (!in_array($value->badge_id, $arr)) {
      //          array_push($arr, $value->badge_id);
      //          array_push($post_data, $value);

      //          $rating = Post::where('department_id', $value->department_id)->where('user_id', $value->user_id)->where('flag', 2)->where('badge_id', $value->badge_id)
      //             ->avg('rating');
      //       }
      //    }
      // }
      return $query;
   }
   public static function getPostCount($search,  $department_id, $badge_id, $fromdate, $todate, $user_id)
   {
      $query = self::query()->select(
         'posts.id as post_id',
         'posts.user_id',
         'posts.department_id',
         'posts.rating',
         'posts.comment',
         'posts.flag',
         'departments.department_name',
         'departments.image',
         'departments.created_at',
         'reason_id',
         'posts.created_at'
      )
         ->leftjoin("departments", function ($join) {
            $join->on('posts.department_id', '=', 'departments.id');
         })->where('user_id', $user_id)->with('post_image');
      if ($search) {
         $query->orwhere('department_name', 'like', '%' . $search . '%');
      }
      if ($department_id) {
         $query
            ->where('posts.department_id',  $department_id);
      }
      if ($badge_id) {
         $query->where('badge_id', 'like', $badge_id);
      }
      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $q->wheredate('posts.created_at', '>=', $fromdate);
            $q->wheredate('posts.created_at', '<=', $todate);
         });
      }
      $query = $query->latest('posts.created_at')->get();
      $arr = [];
      $post_data = [];
      // foreach ($query as $key => $value) {
      //    if ($value->badge_id == null) {
      //       array_push($arr, $value->badge_id);
      //       array_push($post_data, $value);
      //    } else {
      //       if (!in_array($value->badge_id, $arr)) {
      //          array_push($arr, $value->badge_id);
      //          array_push($post_data, $value);

      //          $rating = Post::where('department_id', $value->department_id)->where('user_id', $value->user_id)->where('flag', 2)->where('badge_id', $value->badge_id)
      //             ->avg('rating');
      //       }
      //    }
      // }
      return count($query);
   }

   public function post_comment()
   {
      return $this->hasMany('App\DepartmentComment', 'post_id');
   }

   public function post_like()
   {
      return $this->hasMany('App\DepartmentLike', 'post_id');
   }

   public function post_share()
   {
      return $this->hasMany('App\DepartmentShare', 'post_id');
   }

   public function follow_check()
   {
      return $this->hasMany('App\UserDepartmentFollow', 'department_id');
   }
}
