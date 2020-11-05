<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{
    protected $table = 'ethnicities';

    protected $fillable = ['ethnicity_name'];
    protected $hidden  = ['created_at', 'updated_at'];
}
