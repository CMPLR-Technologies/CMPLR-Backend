<?php

namespace App\Services\Blog;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class CreateBlogService{

    //implement the logic of creating a blog
    public function CreateBlog($param,$user)
    {
        //checking if the url already exists
        if(Blog::where('url',$param['url'])->first()!=null)
            return 422;

        //checking if the blog should be a primary blog 
        $primary=false;
        if($user->Blogs->isEmpty())
            $primary=true;

        //creating the blog        
        $blog=Blog::create([
            'title'=>$param['title'],
            'url'=>$param['url'],
            'privacy'=>$param['privacy'],
            'password'=>$param['password'],
            'blog_name'=>$param['url']
        ]);
       // dd($user);
        //connect the blog with the user through many to many relation
        DB::table('blog_users')->insert([
            'user_id'=>$user->id,
            'blog_id'=>$blog->id,
            'primary'=>$primary,
            'full_privileges'=>'true',
            'contributor_privileges'=>'false'
        ]);
       
        return 201;
    }

}
