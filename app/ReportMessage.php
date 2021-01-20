<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportMessage extends Model
{
    //
    protected $fillable = ['message'];
    protected $hidden  = ['created_at', 'updated_at'];
}
