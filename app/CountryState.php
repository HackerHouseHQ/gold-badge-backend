<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryState extends Model
{
  protected $table = 'country_states';

  protected $fillable = ['country_id', 'state_name'];


  public function getdata_table($order_by, $offset, $limit_t, $search)
  {
    $query = Country::leftjoin("country_states", function ($join) {
      $join->on('countries.id', '=', 'country_states.country_id');
    })
      ->leftjoin("cities", function ($join) {
        $join->on('country_states.id', '=', 'cities.state_id');
      });
    if ($search) {
      $query->orwhere('country_name', 'like', '%' . $search . '%');
      $query->orwhere('state_name', 'like', '%' . $search . '%');
    }
    $query->skip($offset);
    $query->take($limit_t);
    $data = $query->get(); //->toArray();
    // $data = $query->get()->toArray();
    // echo"<pre>";print_r($data);  die;
    return $data;
  }
  public function getdata_count($order_by, $search)
  {
    $query = Country::leftjoin("country_states", function ($join) {
      $join->on('countries.id', '=', 'country_states.country_id');
    })
      ->leftjoin("cities", function ($join) {
        $join->on('country_states.id', '=', 'cities.state_id');
      });
    if ($search) {
      $query->orwhere('country_name', 'like', '%' . $search . '%');
      $query->orwhere('state_name', 'like', '%' . $search . '%');
    }
    $data = $query->get();
    $total = $data->count();
    return $total;
  }
  public function country_data()
  {
    return $this->belongsTo('App\Country', 'country_id');
  }
  public function city_data()
  {
    return $this->hasMany('App\City', 'state_id');
  }
}
