<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadMediaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Upload Media Controller
    |--------------------------------------------------------------------------|
    | This controller handles upload of 
    | Images and videos
    |
   */

    /**
     * This Function Used to upload images to s3 Bucket
     * @param request $request
     * @return response
     */

    public function UploadImagesaa(request $request)
    {
        
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
        ]);
        $user = auth('api')->user();
        // get image
        $image = $request->file('image');
        // remove spaces from image name
        $image_client_name = str_replace(' ', '', $image->getClientOriginalName());
        // name of image must be unique
        $image_name = time() . '_' . $user->id . '_' . $image_client_name;
        // path of image inside s3 bucket
        $filePath = 'images/' . $image_name;
        // store image
        try {
            Storage::disk('s3')->put($filePath, file_get_contents($image));
        } catch (\Throwable $th) {
            $error['image'] = 'failed to upload image';
            return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
        }
        $dimensions = getimagesize($image);
        $response['width'] = $dimensions[0];
        $response['height'] = $dimensions[1];
        // get link
        // both work need to test which better
        //$url = Storage::disk('s3')->url($filePath);
        $url = env('AWS_URL') . $filePath;
        $response['url'] = $url;

        return $this->success_response($response, 200);
    }
    
    /**
     * This Function Used to upload Videos to s3 Bucket
     * @param request $request
     * @return response
     */
    public function UploadVideos(request $request)
    {

        $request->validate([
            'video' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required'
        ]);
        $user = Auth::user();
        // get video
        $video = $request->file('video');
        // remove spaces from video name
        $video_client_name = str_replace(' ', '', $video->getClientOriginalName());
        //name of video must be unique
        $video_name = time() . '_' . $user->id . '_' . $video_client_name;
        $filePath = 'videos/' . $video_name;
        try {
            Storage::disk('s3')->put($filePath, file_get_contents($video));
        } catch (\Throwable $th) {
            $error['video'] = 'failed to upload image';
            return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
        }
        // get link
        // $url = Storage::disk('s3')->url($filePath);
        // faster
        $url = env('AWS_URL') . $filePath;
        $response['url'] = $url;
        return $this->success_response($response, 200);
    }
   
}
