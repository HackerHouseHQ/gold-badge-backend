<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenderOption extends Model
{
    //
      protected $table = 'gender_options';
    
    protected $fillable = ['name'];
}
