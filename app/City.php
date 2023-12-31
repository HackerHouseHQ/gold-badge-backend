<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'cities';

    protected $fillable = ['country_id', 'state_id', 'city_name'];
}
