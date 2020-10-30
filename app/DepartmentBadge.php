<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use DB;
use GuzzleHttp\Psr7\Request;

class DepartmentBadge extends Model
{

   protected $table = 'department_badges';

   protected $fillable = ['department_id', 'badge_number', 'rating', 'status'];
   public function reportReason()
   {
   }

   public function getdata_badge_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $city_id)
   {


      // DB::enableQueryLog();

      $query = self::query()->with('department_data.country_data')->with('department_data.state_data')->with('department_data.city_data')->orderBy('created_at', 'asc');
      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $q->wheredate('created_at', '>=', date("Y-m-d", strtotime($fromdate)));
            $q->wheredate('created_at', '<=', date("Y-m-d", strtotime($todate)));
         });
      }
      if (!empty($status_id)) {
         $query->Where(function ($q) use ($status_id) {
            $q->where('status', $status_id);
         });
      }
      if (!empty($country_id)) {
         $query->whereHas('department_data', function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
         });
      }
      if (!empty($state_id)) {
         $query->whereHas('department_data', function ($q) use ($state_id) {
            $q->where('state_id', $state_id);
         });
      }
      if (!empty($city_id)) {
         $query->whereHas('department_data', function ($q) use ($city_id) {
            $q->where('city_id', $city_id);
         });
      }

      if (!empty($search)) {
         $query->whereHas('department_data', function ($q) use ($search) {
            $q->where('department_name', 'like', '%' . $search . '%');
         });
         $query->Where(function ($q) use ($search) {
            $q->orwhere('badge_number', 'like', '%' . $search . '%');
         });
      }


      $query->skip($offset);
      $query->take($limit_t);
      $data = $query->get();
      // $data = $query->get()->toArray();
      //   $data = DB::getQueryLog();
      //  echo"<pre>";print_r($data);  die;
      return $data;
   }
   public function getdata_badge_count($order_by, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $city_id)
   {
      $query = self::query()->with('department_data.country_data')->with('department_data.state_data')->with('department_data.city_data')->orderBy('created_at', 'asc');

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
         $query->whereHas('department_data', function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
         });
      }
      if (!empty($state_id)) {
         $query->whereHas('department_data', function ($q) use ($state_id) {
            $q->where('state_id', $state_id);
         });
      }
      if (!empty($city_id)) {
         $query->whereHas('department_data', function ($q) use ($city_id) {
            $q->where('city_id', $city_id);
         });
         // });
      }
      if (!empty($search)) {
         $query->whereHas('department_data', function ($q) use ($search) {
            $q->where('department_name', 'like', '%' . $search . '%');
         });
         $query->Where(function ($q) use ($search) {
            $q->orwhere('badge_number', 'like', '%' . $search . '%');
         });
      }

      // $que
      $data = $query->get();
      $total = $data->count();
      return $total;
   }
   public function department_data()
   {
      return $this->belongsTo('App\Department', 'department_id');
   }
   public static function getDepartmentBadge($country_id, $state_id, $city_id)
   {
      $query = self::query()->select(
         'department_badges.department_id',
         'department_badges.badge_number',
         'department_badges.id as badge_id'
      )->leftjoin("departments", function ($join) {
         $join->on('departments.id', '=', 'department_badges.department_id');
      })
         ->where('department_badges.status', ACTIVE);
      if ($country_id) {
         $query->Where('departments.country_id', $country_id);
      }
      if ($state_id) {
         $query->Where('departments.state_id', $state_id);
      }
      if ($city_id) {
         $query->Where('departments.city_id', $city_id);
      }
      $data = $query->get();
      return $data;
   }
   public function total_reviews()
   {
      return $this->hasMany('App\Post', 'badge_id');
   }
}
