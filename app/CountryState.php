<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryState extends Model
{
        protected $table = 'country_states';
    
    protected $fillable = ['country_id','state_name'];
}
