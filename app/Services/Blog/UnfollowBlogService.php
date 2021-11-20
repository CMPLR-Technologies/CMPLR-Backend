<?php

namespace App\Services\Blog;


class UnfollowBlogService{


    public function UnfollowBlog($blog,$user)
    {
        //check if the blog doesn't exist
        if($blog==null)
            return 404;
        
        //check if the user is already unfollowing the blog
        if($blog->followedBy($user)==false)
            return 409;
        
        //delete the follow through the relation
        $blog->Followers()->where('user_id',$user->id)->delete();

        return 200;
    }

}
