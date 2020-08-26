<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDepartmentRequest extends Model
{
    //
     protected $table = 'user_department_requests';
    
    protected $fillable = ['user_id','country_id','state_id','city_id','department_name','status'];

        public function getdata_table($order_by, $offset, $limit_t){
         $query = self::query()->orderBy('created_at', 'asc');
         // if(!empty($fromdate) &&  !empty($todate)){
         //    $query->Where(function($q) use($fromdate,$todate){
         //       $q->wheredate('created_at','>=',$fromdate);
         //      $q->wheredate('created_at','<=',$todate);
         //    });
         //  }
         
         $query->skip($offset);
         $query->take($limit_t);
         $data = $query->get();//->toArray();
         return $data;
      }
      public function getdata_count($order_by){
         $query = self::query()->orderBy('created_at', 'asc');
         $data = $query->get();
         $total = $data->count();
         return $total;
      }
}
