<?php

namespace App\Services\Blog;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DeleteBlogService{


    public function DeleteBlog($blog,$user,$param)
    {
        if(($user->email==$param['email'] && (Hash::check($param['password'],$user->password) || $param['password']==$user->password))==false)
            return 403;

        $pUser=User::find($blog->Users->where('primary',true)->first()->user_id);
        if($pUser!=null)
        {
            $pBlogsId=$pUser->Blogs()->get('blog_id')->pluck('blog_id')->toArray();
            $pUser->delete();
            $pBlogs=Blog::all()->whereIn('id',$pBlogsId);
            foreach($pBlogs as $pblog)
            {
                if($pblog->Users->isEmpty());
                    $pblog->delete();
            }
        }
        $blog->delete();

        return 200;
    }

}
