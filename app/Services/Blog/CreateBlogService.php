<?php

namespace App\Services\Blog;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateBlogService{


    public function CreateBlog($param)
    {
        if(Blog::where('url',$param->url)->first()!=null)
            return 422;

        $primary=false;
        if(auth()->user()->Blogs->isEmpty())
            $primary=true;

        
        $blog=Blog::create([
            'title'=>$param->title,
            'url'=>$param->url,
            'privacy'=>$param->privacy,
            'password'=>$param->password,
        ]);

        $blog->Users()->create([
            'user_id'=>auth()->id(),
            'primary'=>$primary,
            'full_privileges'=>'true',
            'contributor_privileges'=>'false'
        ]);

        return 201;
    }

}