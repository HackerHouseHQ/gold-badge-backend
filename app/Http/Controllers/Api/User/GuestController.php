<?php

namespace App\Http\Controllers\Api\User;

use App\Post;
use Exception;
use App\GuestUser;
use App\DepartmentLike;
use Illuminate\Http\Request;
use App\UserDepartmentFollow;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\User\UserController;

class GuestController extends Controller
{
    function __construct()
    {
        $this->userController = new UserController;
    }
    public function guestLogin(Request $request)
    {
        if ($request->device_id) {
            $guest = GuestUser::where('device_id', $request->device_id)->first();
            if ($guest) {
                $guest->is_active = 1;
                $guest->save();
                return res_success('Login sucessfully');
            } else {
                $insertArray = ['device_id' => $request->device_id];
                $createGuest = GuestUser::create($insertArray);
                return res_success('Login successfully');
            }
        }
    }
    public function guestLogout(Request $request)
    {
        if ($request->device_id) {
            $guestLogout = GuestUser::where('device_id', $request->device_id)->update(['is_active' => 0]);
            return res_success('Logout successfully');
        }
    }
    public function homepage(Request $request)
    {
        // echo "fvf"; die;
        /**
         * get post department .
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            if ($request->type == 1) {
                //  echo "da"; die;
                $user_id = $request->user_id;
                $myPost = UserDepartmentFollow::getPostDepartmentDataGuest($user_id);
                $query = Post::query()->select(
                    'posts.user_id',
                    'posts.id as post_id',
                    'users.user_name',
                    'users.image as user_image',
                    'departments.department_name',
                    'posts.created_at',
                    'posts.comment as post_content',
                    'posts.flag',
                    'posts.department_id',
                    DB::raw('COUNT(posts.department_id) as total_reviews'),
                    DB::raw('AVG(posts.rating) as rating')
                )
                    ->leftjoin("departments", function ($join) {
                        $join->on('posts.department_id', '=', 'departments.id');
                    })
                    ->leftjoin("users", function ($join) {
                        $join->on('posts.user_id', '=', 'users.id');
                    })
                    ->groupBy('departments.id')
                    ->where('flag', 1)
                    ->get();
                $arrz = array();
                foreach ($myPost as $key => $value) {
                    foreach ($query as $k => $v) {
                        if ($v->flag == 1 && $value->flag == 1 && $v->department_id == $value->department_id) {
                            // $departmentLikeCount = DepartmentLike::where('post_id', $value->post_id)->count();
                            // $departmentShareCount = DepartmentShare::where('post_id', $value->post_id)->count();
                            // $departmentCommentCount = DepartmentComment::where('post_id', $value->post_id)->count();
                            $value['total_reviews'] = $v->total_reviews;
                            $value['rating'] = number_format($v->rating,  1);
                            $isdepartmentLike = DepartmentLike::where('post_id', $value->post_id)->where('user_id', $user_id)->first();
                            if ($isdepartmentLike) {
                                $value['is_liked'] = ($isdepartmentLike->status == 1) ? 1 : 0;
                            } else {
                                $value['is_liked'] = 0;
                            }
                            // $value['like_count'] = $departmentLikeCount;
                            // $value['comment_count'] = $departmentCommentCount;
                            // $value['share_count'] = $departmentShareCount;
                            unset($value->flag);
                        }
                    }
                }
                return res_success('Fetch List', array('recentPostList' => $myPost));
            }
            if ($request->type == 2) {
                $user_id = $request->user_id;
                $myPost = UserDepartmentFollow::getPostDepartmentDataLike($user_id);
                $query = Post::query()->select(
                    'posts.user_id',
                    'posts.id as post_id',
                    'users.user_name',
                    'users.image as user_image',
                    'departments.department_name',
                    'posts.created_at',
                    'posts.comment as post_content',
                    'posts.flag',
                    'posts.department_id',
                    DB::raw('COUNT(posts.department_id) as total_reviews'),
                    DB::raw('AVG(posts.rating) as rating')
                )
                    ->leftjoin("departments", function ($join) {
                        $join->on('posts.department_id', '=', 'departments.id');
                    })
                    ->leftjoin("users", function ($join) {
                        $join->on('posts.user_id', '=', 'users.id');
                    })
                    ->groupBy('departments.id')
                    ->where('flag', 1)
                    ->get();
                $arrz = array();
                foreach ($myPost as $key => $value) {
                    foreach ($query as $k => $v) {
                        if ($v->flag == 1 && $value->flag == 1 && $v->department_id == $value->department_id) {
                            // $departmentLikeCount = DepartmentLike::where('post_id', $value->post_id)->count();
                            // $departmentShareCount = DepartmentShare::where('post_id', $value->post_id)->count();
                            // $departmentCommentCount = DepartmentComment::where('post_id', $value->post_id)->count();
                            $value['total_reviews'] = $v->total_reviews;
                            $value['rating'] = number_format($v->rating,  1);
                            // $value['like_count'] = $departmentLikeCount;
                            // $value['comment_count'] = $departmentCommentCount;
                            // $value['share_count'] = $departmentShareCount;
                            $isdepartmentLike = DepartmentLike::where('post_id', $value->post_id)->where('user_id', $user_id)->first();
                            if ($isdepartmentLike) {
                                $value['is_liked'] = ($isdepartmentLike->status == 1) ? 1 : 0;
                            } else {
                                $value['is_liked'] = 0;
                            }
                            unset($value->flag);
                        }
                    }
                }
                return res_success('Fetch List', array('mostLikedPostList' => $myPost));
            }
            if ($request->type == 3) {
                $user_id = $request->user_id;
                $myPost = UserDepartmentFollow::getPostDepartmentDataShare($user_id);
                $query = Post::query()->select(
                    'posts.user_id',
                    'posts.id as post_id',
                    'users.user_name',
                    'users.image as user_image',
                    'departments.department_name',
                    'posts.created_at',
                    'posts.comment as post_content',
                    'posts.flag',
                    'posts.department_id',
                    DB::raw('COUNT(posts.department_id) as total_reviews'),
                    DB::raw('AVG(posts.rating) as rating')
                )
                    ->leftjoin("departments", function ($join) {
                        $join->on('posts.department_id', '=', 'departments.id');
                    })
                    ->leftjoin("users", function ($join) {
                        $join->on('posts.user_id', '=', 'users.id');
                    })
                    ->where('posts.user_id', $user_id)->groupBy('departments.id')
                    ->where('flag', 1)
                    ->get();
                $arrz = array();
                foreach ($myPost as $key => $value) {
                    foreach ($query as $k => $v) {
                        if ($v->flag == 1 && $value->flag == 1 && $v->department_id == $value->department_id) {
                            // $departmentLikeCount = DepartmentLike::where('post_id', $value->post_id)->count();
                            // $departmentShareCount = DepartmentShare::where('post_id', $value->post_id)->count();
                            // $departmentCommentCount = DepartmentComment::where('post_id', $value->post_id)->count();
                            $value['total_reviews'] = $v->total_reviews;
                            $value['rating'] = number_format($v->rating,  1);
                            $isdepartmentLike = DepartmentLike::where('post_id', $value->post_id)->where('user_id', $user_id)->first();
                            if ($isdepartmentLike) {
                                $value['is_liked'] = ($isdepartmentLike->status == 1) ? 1 : 0;
                            } else {
                                $value['is_liked'] = 0;
                            }
                            // $value['like_count'] = $departmentLikeCount;
                            // $value['comment_count'] = $departmentCommentCount;
                            // $value['share_count'] = $departmentShareCount;
                            unset($value->flag);
                        }
                    }
                }
                return res_success('Fetch List', array('mostSharedPostList' => $myPost));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
