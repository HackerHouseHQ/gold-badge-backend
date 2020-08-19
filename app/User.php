<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

   
    protected $fillable = [
        'first_name','last_name','email','mobile_country_code','mobil_no','user_name','dob','image','gender','ethnicity','country_id','state_id','city_id','status'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getdata_table($order_by,$offset, $limit_t){
         $query = self::query()->orderBy('created_at', 'asc');
         $query->skip($offset);
         $query->take($limit_t);
         $data = $query->get();//->toArray();
         // $data = $query->get()->toArray();
         // echo"<pre>";print_r($data);  die;
         return $data;
      }
      public function getdata_count($order_by){
         $query = self::query()->orderBy('created_at', 'asc');
         $data = $query->get();
         $total = $data->count();
         return $total;
      }
}
