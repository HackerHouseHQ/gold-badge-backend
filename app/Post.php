<?php

namespace App;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

   protected $fillable = ['country_id', 'state_id', 'city_id', 'department_name', 'image', 'status', 'id', 'user_id'];


   public function users()
   {
      return $this->belongsTo('App\User', 'user_id');
   }
   public function departments()
   {
      return $this->belongsTo('App\Department', 'department_id');
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
   public static function getPost($search,  $department_id, $badge_id, $fromdate, $todate, $order_by, $limit_t, $offset, $user_id)
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
         })->where('user_id', $user_id);
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
      $query->skip($offset);
      $query->take($limit_t);
      $query = $query->latest('posts.created_at')->get();
      $arr = [];
      $post_data = [];
      foreach ($query as $key => $value) {
         if ($value->badge_id == null) {
            array_push($arr, $value->badge_id);
            array_push($post_data, $value);
         } else {
            if (!in_array($value->badge_id, $arr)) {
               array_push($arr, $value->badge_id);
               array_push($post_data, $value);

               $rating = Post::where('department_id', $value->department_id)->where('user_id', $value->user_id)->where('flag', 2)->where('badge_id', $value->badge_id)
                  ->avg('rating');
            }
         }
      }
      return $post_data;
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
         })->where('user_id', $user_id);
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
      foreach ($query as $key => $value) {
         if ($value->badge_id == null) {
            array_push($arr, $value->badge_id);
            array_push($post_data, $value);
         } else {
            if (!in_array($value->badge_id, $arr)) {
               array_push($arr, $value->badge_id);
               array_push($post_data, $value);

               $rating = Post::where('department_id', $value->department_id)->where('user_id', $value->user_id)->where('flag', 2)->where('badge_id', $value->badge_id)
                  ->avg('rating');
            }
         }
      }
      return count($post_data);
   }
}
