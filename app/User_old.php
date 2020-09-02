<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Department;

class User extends Authenticatable
{
   use Notifiable;


   protected $fillable = [
      'first_name', 'last_name', 'email', 'mobile_country_code', 'mobil_no', 'user_name', 'dob', 'image', 'gender', 'ethnicity', 'country_id', 'state_id', 'city_id', 'status'
   ];

   protected $casts = [
      'email_verified_at' => 'datetime',
   ];

   public function getdepdata_table($order_by, $offset, $limit_t)
   {
       $query = Department::query()
               
            ->leftjoin("department_badge as ds", function ($join) {
                $join->on('ds.department_id', '=', 'departments.id');
            });
               
              // ->orderBy('created_at', 'asc');
   
      $query->skip($offset);
      $query->take($limit_t);
      $data = $query->get(); //->toArray();
      // $data = $query->get()->toArray();
      // echo"<pre>";print_r($data);  die;
      return $data;
}
  public function getdepdata_count($order_by)
   {
      $query = Department::query()->orderBy('created_at', 'asc');

      $data = $query->get();
      $total = $data->count();
      return $total;
   }
public function getdata_table($order_by, $offset, $limit_t, $fromdate, $todate, $status_id, $country_id, $state_id)
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
      $query->skip($offset);
      $query->take($limit_t);
      $data = $query->get(); //->toArray();
      // $data = $query->get()->toArray();
      // echo"<pre>";print_r($data);  die;
      return $data;
   }
   public function getdata_count($order_by,  $fromdate, $todate)
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
      // $que
      $data = $query->get();
      $total = $data->count();
      return $total;
   }
}
