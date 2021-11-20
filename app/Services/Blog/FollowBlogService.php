<?php

namespace App\Services\Blog;


class FollowBlogService{


    public function FollowBlog($blog,$user)
    {
        //check if the blog doesn't exist
        if($blog==null)
            return 404;

        //check if the user is already following the blog
        if($blog->followedBy($user))
            return 409;
        
        //create a follow through the relation
        $blog->Followers()->create([
            'user_id'=>$user->id
        ]);

        return 200;
    }

}
