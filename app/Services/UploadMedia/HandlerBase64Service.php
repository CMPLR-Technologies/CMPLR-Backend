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

    public function GenerateVideoName($video,$userId)
    {
        $video_client_name = str_replace(' ', '', $video->getClientOriginalName());
        //name of video must be unique
        $video_name = time() . '_' . $userId . '_' . $video_client_name;
        $filePath = 'videos/' . $video_name;
        return $filePath ;
    }

    /**
     * this function responsible for validate base64 image
     * @param string $base64_data
     * @return string
     */
    public function Base64Validations($base64Data)
    {
        if (!base64_decode($base64Data, true))
            return null;

        $binaryData = base64_decode($base64Data);

        if (base64_encode($binaryData) !== $base64Data)
            return null;

        return $binaryData;
    }

     /**
     * this function responsible for validate base64 image extention
     * @param string $base64_data
     * @return string
     */
    public function ValidateEXtension($base64Data)
    {
        $imageType = explode("image/", $base64Data);
        $extension = $imageType[1];

        if (in_array(Str::lower($extension), Config::ALLOWED_EXTENSIONS))
            return $extension;
        return null;
    }

    /**
     * this function responsible for Generate image name
     * @param string $base64_data
     * @return string
     */
    public function GenerateImageName($extension)
    {
        $fileName = time() . '_' . Str::random(15) . '.' . $extension;
        $filePath = Config::IMAGE_PATH . $fileName;
        return $filePath;
    }
    
    /**
     * This function responsible for generate image name
     */
    public function GenerateFileName($image,$userId)
    {
        $imageClientName = str_replace(' ', '', $image->getClientOriginalName());
        // name of image must be unique
        $imageName = time() . '_' . $userId . '_' . $imageClientName;
        // path of image inside s3 bucket
        $filePath = 'images/' . $imageName;
        return $filePath;
    }

    public function ValidateImageSize(string $binaryData)
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binaryData);
        if (filesize($tmpFile) / 1024 > Config::MAX_IMAGE_SIZE) 
            return false;
        return true;
    }


}
