<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentShare extends Model
{
    //
    public function post_images()
    {
        return $this->hasMany('App\PostImage', 'post_id', 'post_id');
    }
}
