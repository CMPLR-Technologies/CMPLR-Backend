<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Services\UploadMedia\HandlerBase64Service;
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
    protected $HandlerBase64Service;
    public function __construct(HandlerBase64Service $HandlerBase64Service)
    {
        $this->HandlerBase64Service = $HandlerBase64Service;
    }

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
        // generate the name of the file
        $filePath = $this->HandlerBase64Service->GenerateFileName($image,$user->id);
        // remove spaces from image name
        // $image_client_name = str_replace(' ', '', $image->getClientOriginalName());
        // // name of image must be unique
        // $image_name = time() . '_' . $user->id . '_' . $image_client_name;
        // // path of image inside s3 bucket
        // $filePath = 'images/' . $image_name;
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

    /**
     * This Function is Responisble for upload images in 
     * base64 form
     */
    function UploadBase64Image(request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        // get image 
        $data64 = $request->image;

        // split data to two parts
        $image_parts = explode(";base64,", $data64);

        // validate the image extension
        $extension = $this->HandlerBase64Service->ValidateEXtension($image_parts[0]);
        if (!$extension) {
            $error['image'] = $image_parts[0] . ' type is not supported type';
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }

        // decode and validate image data
        $binary_data = $this->HandlerBase64Service->Base64Validations($image_parts[1]);
        if (!$binary_data) 
        {
            $error['image'] = 'Invalid Base64image Given';
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }

        // check image size
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binary_data);
        if(filesize($tmpFile)/1024 > Config::MAX_IMAGE_SIZE)
        {
            $error['image'] = 'Invalid Base64image Size';
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }

        // generate image name 
        $filePath = $this->HandlerBase64Service->GenerateImageName($extension);

        //upload image on Aws s3 Bucket
        try {
            Storage::disk('s3')->put($filePath, $binary_data);
        } catch (\Throwable $th) {
            $error['image'] = 'failed to upload image';
            return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
        }
        // get image url
        $url = env('AWS_URL') . $filePath;
        $response['url'] = $url;
        return $this->success_response($response, 200);
    }
}
