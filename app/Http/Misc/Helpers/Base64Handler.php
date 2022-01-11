<?php

namespace App\Http\Misc\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Base64Handler
{

    const IMAGE_EXTS = ['jpeg', 'jpg', 'png', 'bmp', 'gif'];
    const PDF_EXTS = ['pdf'];
    const WORD_EXTS = ['docx', 'doc'];
    const AUDIO_EXTS = ['mp3', 'wav', '3gp', '3gpp'];


    public static function getMimeType($encoded_str)
    {
        return explode(';', explode(':', $encoded_str)[1])[0];
    }


    public static function getExtension($encoded_str)
    {
        return explode(';', explode('/', $encoded_str)[1])[0];
    }


    public static function storeFile($encoded_file_str, $driver)
    {
        $extension = self::getExtension($encoded_file_str);
        $file_name = Str::random(40) . '.' . $extension;
        $file = base64_decode(substr($encoded_file_str, strpos($encoded_file_str, ",") + 1));
        Storage::disk($driver)->put($file_name, $file);
        return $file_name;
    }



    public static function storeFileAs($encoded_file_str, $chosen_file_name, $driver)
    {
        $extension = self::getExtension($encoded_file_str);
        $file_name = $chosen_file_name . '.' . $extension;
        $file = base64_decode(substr($encoded_file_str, strpos($encoded_file_str, ",") + 1));
        Storage::disk($driver)->put($file_name, $file);
        return $file_name;
    }
}