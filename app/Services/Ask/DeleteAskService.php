<?php

namespace App\Services\Ask;

use App\Models\Blog;
use App\Models\Post;
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
        
        //check if the authenticated user is a member in this blog
        if($blog->users()->where('user_id',$user->id)->first() == null)
            return 403;

        //delete ask
        $ask->delete();

        return 202;
    }

}
