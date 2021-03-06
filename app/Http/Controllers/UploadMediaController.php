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
     * @OA\Post(
     * path="image_upload",
     * summary="Upload image on aws s3 bucket",
     * description="This method can be used to  upload image",
     * operationId="uploadImage",
     * tags={"Upload"},
     * @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *           @OA\Property(property="image", type="string",example="image.png"),
     *      ),
     *    ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="url", type="string", example="https://cmplrserver.s3.eu-west-2.amazonaws.com/images/1640892214_35_DhAcqQcW0AAL8CG.jpg"),
     *                  ),                                         
     *            
     *           ),
     *     ),
     * security ={{"bearer":{}}},
     * )
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
        // generate the name of the file
        $filePath = $this->HandlerBase64Service->GenerateFileName($image, $user->id);

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
     * @OA\Post(
     * path="video_upload",
     * summary="Upload video on aws s3 bucket",
     * description="This method can be used to  upload video",
     * operationId="uploadVideo",
     * tags={"Upload"},
     * @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *           @OA\Property(property="video", type="string",example="video.png"),
     *      ),
     *    ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="url", type="string", example="https://cmplrserver.s3.eu-west-2.amazonaws.com/images/1640892214_35_DhAcqQcW0AAL8CG.jpg"),
     *                  ),                                         
     *            
     *           ),
     *     ),
     * security ={{"bearer":{}}},
     * )
     */
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

        $filePath = $this->HandlerBase64Service->GenerateVideoName($video, $user->id);
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
     * @OA\Post(
     * path="base64image_upload",
     * summary="Upload base64image_upload on aws s3 bucket",
     * description="This method can be used to  upload base64image_upload",
     * operationId="uploadbase64image_upload",
     * tags={"Upload"},
     * @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *           @OA\Property(property="image", type="string",example="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABA"),
     *      ),
     *    ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="url", type="string", example="https://cmplrserver.s3.eu-west-2.amazonaws.com/images/1640892214_35_DhAcqQcW0AAL8CG.jpg"),
     *                  ),                                         
     *            
     *           ),
     *     ),
     * security ={{"bearer":{}}},
     * )
     */
    /**
     * This Function is Responisble for upload images in 
     * base64 form
     * @param 
     */
    function UploadBase64Image(request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        // get image 
        $data64 = $request->image;

        // split data to two parts
        $imageParts = explode(";base64,", $data64);

        // validate the image extension
        $extension = $this->HandlerBase64Service->ValidateEXtension($imageParts[0]);
        if (!$extension) {
            $error['image'] = $imageParts[0] . ' type is not supported type';
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }

        // decode and validate image data
        $binaryData = $this->HandlerBase64Service->Base64Validations($imageParts[1]);
        if (!$binaryData) {
            $error['image'] = 'Invalid Base64image Given';
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }

        // check image size
        $check_size = $this->HandlerBase64Service->ValidateImageSize($binaryData);
        if (!$check_size) {
            $error['image'] = 'Invalid Base64image Size';
            return $this->error_response(Errors::ERROR_MSGS_422, $error, 422);
        }

        // generate image name 
        $filePath = $this->HandlerBase64Service->GenerateImageName($extension);

        //upload image on Aws s3 Bucket
        try {
            Storage::disk('s3')->put($filePath, $binaryData);
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