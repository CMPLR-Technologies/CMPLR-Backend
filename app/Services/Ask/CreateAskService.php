<?php

namespace App\Services\Ask;

use App\Models\Blog;
use App\Models\Post;
use App\Services\Block\BlockService;
use App\Services\Notifications\NotificationsService;
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

        //check if blocked
        if((new BlockService())->isBlocked($blog->id,auth()->user()->primary_blog_id))
            return 403;

        //get user who asked
        $source_user_id=null;
        if($request['is_anonymous']==false)
            $source_user_id=auth()->id();
        

        //create ask
        $ask=Post::create([
            'blog_id'=>$blog->id,
            'blog_name'=>$blogName,
            'content'=>$request['content'],
            'mobile'=>array_key_exists('mobile',$request )?$request['mobile']:null,
            'post_ask_submit'=>'ask',
            'source_user_id'=>$source_user_id,
            'is_anonymous'=>$request['is_anonymous'],
            'source_content'=>array_key_exists('source_content',$request )?$request['source_content']:null
        ]);    

        //add ask notification
        (new NotificationsService())->CreateNotification(
            $request['is_anonymous']==null?null:auth()->user()->primary_blog_id,
            $blog->id,
            'ask',
            $ask->id,
        );

        return 201;
    }

}
