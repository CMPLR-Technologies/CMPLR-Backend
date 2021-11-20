<?php

namespace App\Services\Blog;


class FollowBlogService{


    public function FollowBlog($blog,$user)
    {
        if($blog==null)
            return 404;
        if($blog->followedBy($user))
            return 409;
        
        $blog->Followers()->create([
            'user_id'=>$user->id
        ]);

        return 200;
    }

}
