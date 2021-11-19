<?php

namespace App\Services\Blog;


class UnfollowBlogService{


    public function UnfollowBlog($blog,$user)
    {
        if($blog==null)
            return 404;
        if($blog->followedBy($user)==false)
            return 409;
        
        $blog->Followers()->where('user_id',$user->id())->delete();

        return 200;
    }

}
