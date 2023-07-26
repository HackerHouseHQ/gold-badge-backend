<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentLike extends Model
{
    public function post_images()
    {
        return $this->hasMany('App\PostImage', 'post_id', 'post_id');
    }
}
