<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use Illuminate\Http\Request;
use App\DepartmentCommentLike;
use App\DepartmentSubCommentLike;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * save post department Like .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function saveCommentLike(Request $request)
    {
        try {
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $comment_id = $request->comment_id;
            $alreadyLiked = DepartmentCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->first();
            if ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 1) {
                $insertData =  DepartmentCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->update(['status' => 0]);
            } elseif ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 0) {
                $insertData =  DepartmentCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->update(['status' => 1]);
            } else {
                $insertArray = [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'comment_id' => $comment_id,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE
                ];
                $insertData = DepartmentCommentLike::insert($insertArray);
            }
            if ($insertData) {
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * save sub comment Like .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function saveSubCommentLike(Request $request)
    {
        try {
            $post_id = $request->post_id;
            $user_id = $request->user_id;
            $comment_id = $request->comment_id;
            $sub_comment_id = $request->sub_comment_id;
            $alreadyLiked = DepartmentSubCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->where('sub_comment_id', $sub_comment_id)->first();
            if ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 1) {
                $insertData =  DepartmentSubCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->where('sub_comment_id', $sub_comment_id)->update(['status' => 0]);
            } elseif ($alreadyLiked && isset($alreadyLiked->status) && $alreadyLiked->status == 0) {
                $insertData =  DepartmentSubCommentLike::where('user_id', $user_id)->where('post_id', $post_id)->where('comment_id', $comment_id)->where('sub_comment_id', $sub_comment_id)->update(['status' => 1]);
            } else {
                $insertArray = [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'comment_id' => $comment_id,
                    'sub_comment_id' => $sub_comment_id,
                    'created_at' => CURRENT_DATE,
                    'updated_at' => CURRENT_DATE
                ];
                $insertData = DepartmentSubCommentLike::insert($insertArray);
            }
            if ($insertData) {
                return res_success('Your like has been saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
