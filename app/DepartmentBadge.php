<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentBadge extends Model
{
    
      protected $table = 'department_badges';
    
    protected $fillable = ['department_id','badge_number','rating','status'];
}
