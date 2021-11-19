<?php

namespace App\Services\Blog;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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