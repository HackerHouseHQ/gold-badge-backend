<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryState extends Model
{
        protected $table = 'country_states';
    
    protected $fillable = ['country_id','state_name'];


	 public function getdata_table($order_by, $offset, $limit_t,$search){
        // print_r($search); die;
         $query = self::query()->with('country_data')->with('city_data')->orderBy('created_at', 'asc');
          if(!empty($search)){
            $query->whereHas('country_data',function($q) use($search){
               $q->where('country_name','like','%'.$search.'%');
            });
        }
         $query->skip($offset);
         $query->take($limit_t);
         $data = $query->get();//->toArray();
         // $data = $query->get()->toArray();
         // echo"<pre>";print_r($data);  die;
         return $data;
	  }
	  public function getdata_count($order_by,$search){
         $query = self::query()->orderBy('created_at', 'asc');
          if(!empty($search)){
            $query->whereHas('country_data',function($q) use($search){
               $q->where('country_name','like','%'.$search.'%');
            });
        }
         $data = $query->get();
         $total = $data->count();
         return $total;
      }
	   public function country_data(){
	     return $this->belongsTo('App\Country', 'country_id');
	    }
	    public function city_data(){
	      return $this->hasMany('App\City', 'state_id');

	    }
  }
