<?php
namespace App\Services\UploadMedia;

use App\Http\Misc\Helpers\Config;
use App\Models\PostNotes;
use Elegant\Sanitizer\Filters\Lowercase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HandlerBase64Service
{
 /*
     |--------------------------------------------------------------------------
     | HandlerBase64Service
     |--------------------------------------------------------------------------|
     | This Service handles upload base64 images and videos
     | on AWS S3 Bucket
     */

    /**
     * this function responsible for validate base64 image
     * @param string $base64_data
     * @return string
     */
    public function Base64Validations($base64_data)
    {
        if(! base64_decode($base64_data,true))
            return null;
        
        $binary_data = base64_decode($base64_data);

        if(base64_encode($binary_data) !== $base64_data)
            return null;

        return $binary_data;
    }

    public function ValidateEXtension($base64_data)
    {
        $image_type = explode("image/", $base64_data);
        $extension = $image_type[1];
        
        if(in_array( Str::lower($extension), Config::ALLOWED_EXTESIONS))
            return $extension;
        return null;
    }

    public function GenerateImageName($extension)
    {
        $file_name = time().'_'. Str::random(15).'.'.$extension;
        $file_path = Config::IMAGE_PATH.$file_name;
        return $file_path;
    }
    
    public function GenerateFileName($image,$user_id)
    {
        $image_client_name = str_replace(' ', '', $image->getClientOriginalName());
        // name of image must be unique
        $image_name = time() . '_' . $user_id . '_' . $image_client_name;
        // path of image inside s3 bucket
        $file_Path = 'images/' . $image_name;
        return $file_Path;
    }
}

