<?php

namespace App\Services\Ask;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use App\Services\Notifications\NotificationsService;
use Illuminate\Support\Facades\DB;

class DeleteAskService{

    /*
    |--------------------------------------------------------------------------
    | DeleteAsk Service
    |--------------------------------------------------------------------------
    | This class handles the logic of DeleteAskController
    |
   */

    /**
    * implements the logic of deleting an Ask
    * 
    * @return int
    */
    public function DeleteAsk($askId,$user)
    {
        //get target ask
        $ask=Post::all()
            ->where('post_ask_submit','ask')
            ->where('id',$askId)
            ->first();

        //check if ask exists
        if($ask==null)
            return 404;

        //get target blog
        $blog=Blog::find($ask->blog_id);
        
        //check if the authenticated user is a member of this blog
        if($blog->users()->where('user_id',$user->id)->first() == null)
            return 403;

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

        //delete ask
        $ask->delete();

        return 202;
    }

}
