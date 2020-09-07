<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class UserDepartmentRequest extends Model
{
   //
   protected $table = 'user_department_requests';

   protected $fillable = ['user_id', 'country_id', 'state_id', 'city_id', 'department_name', 'status'];

   public function getdata_table($order_by, $offset, $limit_t, $type, $search, $fromdate, $todate)
   {
      $query = self::query()->where('status', $type)->orderBy('created_at', 'asc');
      // if(!empty($fromdate) && !empty($todate)){
      // $query->Where(function($q) use($fromdate,$todate){
      // $q->wheredate('created_at','>=',$fromdate);
      // $q->wheredate('created_at','<=',$todate);
      // });
      // }
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
      if (!empty($fromdate) && !empty($todate)) {
         $query->Where(function ($q) use ($fromdate, $todate) {
            // $q->whereBetween('created_at', array($fromdate, $todate));
            $q->wheredate('created_at', '>=', $fromdate);
            $q->wheredate('created_at', '<=', $todate);
            // $q->wheredate('created_at','>=',Carbon::parse($fromdate.' 00:00:00'));
            // $q->wheredate('created_at','<=',Carbon::parse($todate,' 00:00:00'));

            // if ($fromdate) {
            // $q->whereDate('created_at', '>=', Carbon::parse($fromdate));
            // }
            // if ($todate) {
            // $q->whereDate('created_at', '<=', Carbon::parse($todate));
            // }
         });
      }



      $query->skip($offset);
      $query->take($limit_t);
      $data = $query->get(); //->toArray();
      // print_r($data); die;
      return $data;
   }
   public function getdata_count($order_by, $type, $search)
   {
      $query = self::query()->where('status', $type)->orderBy('created_at', 'asc');
      $data = $query->get();
      $total = $data->count();
      return $total;
   }
   public function country()
   {
      return $this->hasOne('App\Country', 'id', 'country_id')->select('id', 'country_name');
   }
   public function state()
   {
      return $this->hasOne('App\CountryState', 'id', 'state_id')->select('id', 'state_name');
   }
   public function city()
   {
      return $this->hasOne('App\City', 'id', 'city_id')->select('id', 'city_name');
   }
   public function userInfo()
   {
      return $this->hasOne('App\User', 'id', 'user_id')->select('id', 'user_name', 'first_name', 'last_name', 'email', 'mobil_no', 'created_at');
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
