<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function UploadImages(request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
        ]);
        $user = Auth::user();
        $image = $request->file('image');

        if ($image) 
        {
            $fileName = time() . '_' . $image->getClientOriginalName();
            // save file to azure blob virtual directory uplaods in your container
            $filePath = $request->file('image')->storeAs('uploads/', $fileName, 'azure');

            return back()
                ->with('success', 'File has been uploaded.');
        }
    }

    public function UploadVideos(request $request)
    {
        $data = $request->all();
        $rules = [
            'video' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required'
        ];
        $validator = Validator($data, $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $video = $data['video'];
            $input = time() . $video->getClientOriginalExtension();
            $destinationPath = 'uploads/videos';
            $video->move($destinationPath, $input);

            $user['video']       = $input;
            return redirect()->back()->with('upload_success', 'upload_success');
        }
    }
}
