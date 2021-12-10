<?php

namespace App\Services\Ask;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class CreateAskService{

    /*
    |--------------------------------------------------------------------------
    | CreateAsk Service
    |--------------------------------------------------------------------------
    | This class handles the logic of CreateAskController
    |
   */

    /**
     * implements the logic of creating an Ask
     * 
     * @return int
     */
    public function CreateAsk($request,$blogName)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();
        
        //check if blog exists
        if($blog==null)
            return 404;

         //get user who asked
         $source_user_id=null;
         if($request->is_anonymous==false)
            $source_user_id=auth()->id();
         
 
         //create ask
         Post::create([
             'blog_name'=>$blogName,
             'content'=>$request->content,
             'layout'=>$request->layout,
             'format'=>$request->format,
             'mobile'=>$request->mobile,
             'post_ask_submit'=>'ask',
             'source_user_id'=>$source_user_id,
             'is_anonymous'=>$request->is_anonymous
         ]);    

        return 201;
    }

}
