<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ReportPost extends Model
{
    //
    public function getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id)
    {
        $query  = self::query()->select(
            'posts.id',
            'posts.user_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'posts.created_at'
        )->leftJoin('posts', 'report_posts.post_id', '=', 'posts.id')
            ->groupBy('posts.user_id', 'posts.flag')
            ->latest();
    }
}
