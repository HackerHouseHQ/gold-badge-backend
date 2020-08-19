<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
        protected $table = 'departments';
    
    protected $fillable = ['country_id','state_id','city_id','department_name','image','status'];
}
