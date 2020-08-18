<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
      // use Notifiable;
    protected $table = 'countries';
    
    protected $fillable = ['country_name'];

   
}
