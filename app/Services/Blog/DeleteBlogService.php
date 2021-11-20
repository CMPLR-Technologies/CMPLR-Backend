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
        $pUser=User::find($blog->Users->where('primary',true)->first()->user_id);
        if($pUser!=null)
        {
            //deleting the user
            $pBlogsId=$pUser->Blogs()->get('blog_id')->pluck('blog_id')->toArray();
            $pUser->delete();

            //deleting all the blogs that are related to this deleted user only
            $pBlogs=Blog::all()->whereIn('id',$pBlogsId);
            foreach($pBlogs as $pblog)
            {
                if($pblog->Users->isEmpty())
                    $pblog->delete();
            }
        }

        //deleting the blog
        $blog->delete();

        return 200;
    }

}
