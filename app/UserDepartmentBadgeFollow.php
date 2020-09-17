<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDepartmentBadgeFollow extends Model
{
    //
    public function badge()
    {
        return $this->belongsTo('App\DepartmentBadge', 'badge_id');
    }
}
