<?php

namespace App\Services\Ask;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use App\Services\Notifications\NotificationsService;
use Carbon\Carbon;

class AnswerAskService{

    /*
    |--------------------------------------------------------------------------
    | AnswerAsk Service
    |--------------------------------------------------------------------------
    | This class handles the logic of AnswerAskController
    |
   */

    /**
     * implements the logic of creating an Ask
     * 
     * @return int
     */
    public function AnswerAsk($request,$askId,$user)
    {
        //get target ask
        $ask=Post::where('id',$askId)
            ->where('post_ask_submit','ask')
            ->first();
        
        //check if ask exists
        if($ask==null)
            return 404;


        //get target blog
        $blog=Blog::find($ask->blog_id);

        //check if the authenticated user is a member in this blog
        if($blog->users->contains('id',$user->id) == false)
            return 403;

        //turn ask into a normal post
        $ask->content=$request['content'];
        $ask->mobile=array_key_exists('mobile',$request )?$request['mobile']:null;
        $ask->post_ask_submit='post';
        $ask->source_content=array_key_exists('source_content',$request )?$request['source_content']:null;
        $ask->tags=array_key_exists('tags',$request )?$request['tags']:null;
        $ask->state=$request['state'];
        $ask->date=Carbon::now()->toRfc850String();

        //update 
        $ask->update();

        //get source_user primary blog id
        $primaryBlogId=null;
        if($ask->source_user_id!=null)
            $primaryBlogId=User::find($ask->source_user_id)->primary_blog_id;

        //delete ask notification
        (new NotificationsService())->DeleteNotification(
            $primaryBlogId,
            $ask->blog_id,
            'ask',
            $ask->id,
        );

        //add answer notification
        if($ask->source_user_id!=null)
            (new NotificationsService())->CreateNotification(
                $ask->blog_id,
                $primaryBlogId,
                'answer',
                $ask->id,
            );

        return 200;
    }

}
