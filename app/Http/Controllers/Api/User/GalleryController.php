<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use App\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    // function correctImageOrientation($filename)
    // {
    //     if (function_exists('exif_read_data')) {
    //         $exif = exif_read_data($filename);
    //         if ($exif && isset($exif['Orientation'])) {
    //             $orientation = $exif['Orientation'];
    //             if ($orientation != 1) {
    //                 $img = imagecreatefromjpeg($filename);
    //                 $deg = 0;
    //                 switch ($orientation) {
    //                     case 3:
    //                         $deg = 180;
    //                         break;
    //                     case 6:
    //                         $deg = 270;
    //                         break;
    //                     case 8:
    //                         $deg = 90;
    //                         break;
    //                 }
    //                 if ($deg) {
    //                     $img = imagerotate($img, $deg, 0);
    //                 }
    //                 // then rewrite the rotated image back to the disk as $filename
    //                 imagejpeg($img, $filename, 95);
    //             } // if there is some rotation necessary
    //         } // if have the exif orientation info
    //     } // if function exists
    // }
    public function saveGalleryImage(Request $request)
    {
        try {
            // check user is active or in active
            Log::info($request->all());
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }

            $validator = Validator::make(
                $request->all(),
                [

                    'media_type' => 'required',
                    'saveFile' =>  'required|array',
                    'videoFile' => 'nullable|array'
                ]
            );
            /**
             * Check input parameter validation
             */

            if ($validator->fails()) {
                return res_validation_error($validator); //Sending Validation Error Message
            }
            $saveFile = $request->saveFile;
            $media_type = $request->media_type; //0 => video 1=>image
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
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $img = Image::make($file->getRealPath());
                    $img->orientate();
                    $height = Image::make($file->getRealPath())->height();
                    $width = Image::make($file->getRealPath())->width();
                    $img->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($path . '/' . $filename);


                    // $file->move($path, $filename);

                    if (!empty($videoFile)) {
                        $videoFile = $videoFile[$j];
                        $videoExtension = $videoFile->getClientOriginalExtension();
                        $videoFilename = time()  . "$i" . "." . $videoExtension;
                        $videoPath = storage_path() . '/app/public/uploads/gallery_video';
                        if (!file_exists($videoPath)) {
                            mkdir($videoPath, 777, true);
                        }
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
                if ($media_type) {
                    return  res_success('Image saved successfully.');
                } else {
                    return  res_success('Video saved successfully.');
                }
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
                )->where('user_id', Auth::user()->id)->where('created_at', 'LIKE', '%' . date('Y-m-d', strtotime($value->date)) . '%')->latest()->get();
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
