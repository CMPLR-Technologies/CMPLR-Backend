<?php

namespace App\Services\Blog;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class CreateBlogService{

    //implement the logic of creating a blog
    public function CreateBlog($param,$user)
    {
        //checking if the blogName already exists
        if(Blog::where('blog_name',$param['blogName'])->first()!=null)
            return 422;

        //checking if the blog should be a primary blog 
        $primary=false;
        if($user->Blogs->isEmpty())
            $primary=true;

        //creating the blog        
        $blog=Blog::create([
            'title'=>$param['title'],
            'blog_name'=>$param['blogName'],
            'privacy'=>$param['privacy'],
            'password'=>array_key_exists('password',$param )?$param['password']:null,
            'url'=>'http://localhost/blogs/'.$param['blogName']
        ]);

        //connect the blog with the user through many to many relation
        DB::table('blog_users')->insert([
            'user_id'=>$user->id,
            'blog_id'=>$blog->id,
            'primary'=>$primary,
            'full_privileges'=>'true',
            'contributor_privileges'=>'false'
        ]);

        DB::table('blog_settings')->insert([
            'blog_id' => $blog->id,
        ]);

       
        return 201;
    }

}
