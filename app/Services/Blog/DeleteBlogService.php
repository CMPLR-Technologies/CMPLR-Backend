<?php

namespace App\Services\Blog;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DeleteBlogService{


    public function DeleteBlog($blog,$user,$param)
    {
        //confirming the user's email and password before deleting 
        if(($user->email==$param['email'] && (Hash::check($param['password'],$user->password) || $param['password']==$user->password))==false)
            return 403;

        //in case this blog is a primary blog to a user get this user
        $pUser=$blog->users()->where('primary',true)->first();

        //deleting the blog
        $blog->delete();

        if($pUser!=null)
        {
            //get all blogs of the user
            $pBlogs=$pUser->realBlogs;

            //deleting all the blogs that are related to this deleted user only
            foreach($pBlogs as $pblog)
            {
                if($pblog->users->isEmpty());
                    $pblog->delete();
            }

            //deleting the user
            $pUser->delete();
        }

        return 200;
    }

}
