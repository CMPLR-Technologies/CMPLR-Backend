<?php

namespace App\Services\Blog;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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