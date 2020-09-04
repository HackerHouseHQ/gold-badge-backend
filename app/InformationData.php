<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformationData extends Model
{
    //
    protected $table = 'information_data';
    
    protected $fillable = ['about_us','privacy','terms'];
}
