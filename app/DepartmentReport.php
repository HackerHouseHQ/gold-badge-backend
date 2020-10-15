<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DepartmentReport extends Model
{
    public function report()
    {
        return $this->hasMany('App\DepartmentReport', 'post_id', 'post_id');
    }
    public function post_images()
    {
        return $this->hasMany('App\PostImage', 'post_id', 'post_id');
    }
    public function getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id)
    {
        $query  = self::query()->select(
            'posts.id',
            'users.user_name',
            'users.first_name',
            'users.last_name',
            'users.status',
            'posts.user_id',
            'posts.badge_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'posts.created_at',
            'department_badges.badge_number',
            'departments.department_name',
            'departments.country_id',
            'departments.state_id',
            'departments.city_id',
            DB::raw('avg(posts.rating) as rating')
        )->leftJoin('posts', 'department_reports.post_id', '=', 'posts.id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('departments', 'posts.department_id', '=', 'departments.id')
            ->leftJoin('department_badges', 'posts.badge_id', '=', 'department_badges.id')
            ->withCount('report')
            ->groupBy('posts.user_id', 'posts.flag', 'department_reports.post_id');
        if (!empty($fromdate) &&  !empty($todate)) {
            $query->Where(function ($q) use ($fromdate, $todate) {
                $q->wheredate('posts.created_at', '>=', $fromdate);
                $q->wheredate('posts.created_at', '<=', $todate);
            });
        }
        if (!empty($search)) {

            $query->where('first_name', 'like', '%' . $search . '%');
            $query->orwhere('last_name', 'like', '%' . $search . '%');
            $query->orwhere('user_name', 'like', '%' . $search . '%');
        }
        if (!empty($status_id)) {

            $query->where('users.status', $status_id);
        }
        if (!empty($department_id)) {

            $query->where('posts.department_id', $department_id);
        }
        if (!empty($badge_id)) {
            $query->where('posts.badge_id', $badge_id);
        }
        if (!empty($country_id)) {

            $query->where('departments.country_id', $country_id);
        }
        if (!empty($state_id)) {

            $query->where('departments.state_id', $state_id);
        }
        if (!empty($city_id)) {
            $query->where('departments.city_id', $city_id);
        }
        $query->skip($offset);
        $query->take($limit_t);
        $data = $query->latest()->get();
        return $data;
    }
    public function getdata_count($status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id)
    {
        $query  = self::query()->select(
            'posts.id',
            'users.user_name',
            'users.first_name',
            'users.last_name',
            'users.status',
            'posts.user_id',
            'posts.badge_id',
            'posts.department_id',
            'posts.rating',
            'posts.flag',
            'posts.created_at',
            'department_badges.badge_number',
            'departments.department_name',
            'departments.country_id',
            'departments.state_id',
            'departments.city_id',
            DB::raw('avg(posts.rating) as rating')
        )->leftJoin('posts', 'department_reports.post_id', '=', 'posts.id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('departments', 'posts.department_id', '=', 'departments.id')
            ->leftJoin('department_badges', 'posts.badge_id', '=', 'department_badges.id')
            ->withCount('report')
            ->groupBy('posts.user_id', 'posts.flag', 'department_reports.post_id');
        if (!empty($fromdate) &&  !empty($todate)) {
            $query->Where(function ($q) use ($fromdate, $todate) {
                $q->wheredate('posts.created_at', '>=', $fromdate);
                $q->wheredate('posts.created_at', '<=', $todate);
            });
        }
        if (!empty($search)) {

            $query->where('first_name', 'like', '%' . $search . '%');
            $query->orwhere('last_name', 'like', '%' . $search . '%');
            $query->orwhere('user_name', 'like', '%' . $search . '%');
        }
        if (!empty($status_id)) {

            $query->where('users.status', $status_id);
        }
        if (!empty($department_id)) {

            $query->where('posts.department_id', $department_id);
        }
        if (!empty($badge_id)) {
            $query->where('posts.badge_id', $badge_id);
        }
        if (!empty($country_id)) {

            $query->where('departments.country_id', $country_id);
        }
        if (!empty($state_id)) {

            $query->where('departments.state_id', $state_id);
        }
        if (!empty($city_id)) {
            $query->where('departments.city_id', $city_id);
        }

        $data = $query->get();
        return count($data);
    }
}
