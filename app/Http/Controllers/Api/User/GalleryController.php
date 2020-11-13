<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use App\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function saveGalleryImage(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $saveFile = $request->saveFile;
            $media_type = $request->media_type;
            $videoFile = $request->videoFile;
            if (isset($saveFile) && !empty($saveFile)) {
                $arr = $saveFile;
                if (!is_array($arr)) {
                    $arr = json_decode($arr, true);
                }
                $i = 1;
                $j = 0;
                foreach ($arr as $image) {
                    $file = $image;
                    $extension = $file->getClientOriginalExtension();
                    $filename = time()  . "$i" . "." . $extension;
                    $path = storage_path() . '/app/public/uploads/gallery_image';
                    $file->move($path, $filename);
                    $videoFile = $videoFile[$j];
                    if (!empty($videoFile)) {
                        $videoExtension = $videoFile->getClientOriginalExtension();
                        $videoFilename = time()  . "$i" . "." . $videoExtension;
                        $videoPath = storage_path() . '/app/public/uploads/gallery_video';
                        $videoFile->move($videoPath, $videoFilename);
                    }
                    $insertArray = [
                        'user_id' => Auth::user()->id,
                        'image'  => $filename,
                        'video' => (!empty($videoFile)) ? $videoFilename : null,
                        'media_type' => $media_type,
                        'created_at' => CURRENT_DATE,
                        'updated_at' => CURRENT_DATE
                    ];
                    $insertData = GalleryImages::insert($insertArray);
                    $i++;
                    $j++;
                }
            }
            if ($insertData) {
                return  res_success('Images saved successfully.');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getGalleryImage(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $siteUrl = env('APP_URL');
            $data  = GalleryImages::select(DB::raw('DISTINCT(DATE(created_at)) as date'))->where('user_id', Auth::user()->id)->latest('date', 'DESC')->get();
            foreach ($data as $key => $value) {
                $images = GalleryImages::select(
                    'id as image_id',
                    DB::raw("CONCAT('$siteUrl','storage/uploads/gallery_image/', image) as image"),
                    'media_type',
                    DB::raw("CONCAT('$siteUrl','storage/uploads/gallery_video/', video) as video"),
                    'created_at'
                )->where('user_id', Auth::user()->id)->where('created_at', 'LIKE', '%' . date('Y-m-d', strtotime($value->date)) . '%')->get();
                $value->images  = $images;
            }
            return res_success(trans('messages.successFetchList'), array('galleryImages' => $data));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function deleteGalleryImage(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $data = GalleryImages::where('id', $request->image_id)->first();
            $filename = $data->image;
            $storage_delete = unlink(storage_path('app/public/uploads/gallery_image/' . $filename));
            if ($storage_delete) {
                $delete = GalleryImages::where('id', $request->image_id)->delete();
                if ($delete) {
                    return res_success('Deleted successfully');
                }
            } else {
                return res_failed('No such file exists');
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
