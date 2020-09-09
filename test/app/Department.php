<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Department extends Model
{
   protected $table = 'departments';

   protected $fillable = ['country_id', 'state_id', 'city_id', 'department_name', 'image', 'status'];

   public function getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search)
   {
      // DB::enableQueryLog();

      $query = self::query()->with('country_data')->with('state_data')->with('city_data')->orderBy('created_at', 'asc');
      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
            $q->wheredate('created_at', '>=', $fromdate);
            $q->wheredate('created_at', '<=', $todate);
         });
      }
      if (!empty($search)) {
         $query->whereHas('country_data', function ($q) use ($search) {
            $q->orwhere('country_name', 'like', '%' . $search . '%');
         });
         $query->whereHas('state_data', function ($q) use ($search) {
            $q->orwhere('state_name', 'like', '%' . $search . '%');
         });
         $query->whereHas('city_data', function ($q) use ($search) {
            $q->orwhere('city_name', 'like', '%' . $search . '%');
         });
         $query->Where(function ($q) use ($search) {
            $q->orwhere('department_name', 'like', '%' . $search . '%');
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
      // $data = DB::getQueryLog();
      // echo"<pre>";print_r($data);  die;
      return $data;
   }
   public function getdata_count($order_by, $status_id, $state_id, $country_id, $fromdate, $todate, $search)
   {

      $query = self::query()->orderBy('created_at', 'asc');

      if (!empty($fromdate) &&  !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
            $q->wheredate('created_at', '>=', $fromdate);
            $q->wheredate('created_at', '<=', $todate);
         });
      }
      if (!empty($search)) {
         $query->whereHas('country_data', function ($q) use ($search) {
            $q->orwhere('country_name', 'like', '%' . $search . '%');
         });
         $query->whereHas('state_data', function ($q) use ($search) {
            $q->orwhere('state_name', 'like', '%' . $search . '%');
         });
         $query->whereHas('city_data', function ($q) use ($search) {
            $q->orwhere('city_name', 'like', '%' . $search . '%');
         });
         $query->Where(function ($q) use ($search) {
            $q->orwhere('department_name', 'like', '%' . $search . '%');
         });
      }
      if (!empty($status_id)) {
         $query->Where(function ($q) use ($status_id) {
            $q->where('status', $status_id);
         });
      }
      // $que
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
}