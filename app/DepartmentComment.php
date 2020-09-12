<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DepartmentComment extends Model
{
    public function sub_comment()
    {
        $siteUrl = env('APP_URL');

        return $this->hasMany('App\DepartmentSubComment', 'comment_id', 'comment_id')->select(
            'department_sub_comments.id as sub_comment_id',
            'department_sub_comments.comment_id',
            'user_id',
            'post_id',
            'sub_comment',
            'users.user_name',
            DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"),
        )
            ->leftjoin("users", function ($join) {
                $join->on('department_sub_comments.user_id', '=', 'users.id');
            });
    }
}
