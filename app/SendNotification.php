<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model
{
    protected $table = 'send_notifications';
    
    protected $fillable = ['title','message','user_id'];


    public function getdata_table($order_by,$offset, $limit_t,$date1,$todate,$fromdate){
         $query = self::query()->orderBy('created_at', 'asc');
         if(!empty($date1)){
              $todaydate = date("Y-m-d");// current date
               $after_one_week_date = date("Y-m-d", strtotime("-1 week"));
               $after_two_week_date = date("Y-m-d", strtotime("-2 week"));
               $month_date = date("Y-m-d", strtotime("-1 month"));
            if($date1 == 1){
                  $fromdate1 =   $todaydate;   
                  $todate1 =   $todaydate;
            } elseif($date1 == 2){
                  $fromdate1 =   $after_one_week_date;   
                  $todate1 =   $todaydate;
            } elseif($date1 == 3){
                  $fromdate1 =   $after_two_week_date;   
                  $todate1 =   $todaydate;
            } elseif($date1 == 4){
                  $fromdate1 =   $month_date;   
                  $todate1 =   $todaydate;
            }
           $query->Where(function($q) use($fromdate1,$todate1){
               $q->wheredate('created_at','>=',$fromdate1);
              $q->wheredate('created_at','<=',$todate1);
            });
         } else {            
         if(!empty($fromdate) &&  !empty($todate)){
            $query->Where(function($q) use($fromdate,$todate){
               $q->wheredate('created_at','>=',$fromdate);
              $q->wheredate('created_at','<=',$todate);
            });
          }
         }
         $query->skip($offset);
         $query->take($limit_t);
         $data = $query->get();//->toArray();
         // $data = $query->get()->toArray();
       //   echo"<pre>";print_r($data);  die;
         return $data;
      }
      public function getdata_count($order_by,$date1,$todate,$fromdate){
         $query = self::query()->orderBy('created_at', 'asc');
         if(!empty($fromdate) &&  !empty($todate)){
            $query->Where(function($q) use($fromdate,$todate){
               $q->wheredate('created_at','>=',$fromdate);
              $q->wheredate('created_at','<=',$todate);
            });
          }

         $data = $query->get();
         $total = $data->count();
         return $total;
      }

}
