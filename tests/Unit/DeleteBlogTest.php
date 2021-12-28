<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use App\Services\Blog\DeleteBlogService;
use Tests\TestCase;
use Illuminate\Support\Str;

class DeleteBlogTest extends TestCase
{
    //testing if wrong parameters were sent
    public function test_InvalidData()
    {
        $blog=Blog::take(1)->first();

        //getting a user with a full privileges 
        $user=$blog->users->first();

        $param=[
            'email'=>null,
            'password'=>null
        ];

        $code=(new DeleteBlogService())->DeleteBlog($blog,$user,$param);
                                                    
        $this->assertEquals(403,$code);
    }

    //testing if the request is valid
    public function test_Success()
    {
        $blog=Blog::take(1)->first();

        //getting a user which is a member of the blog 
        $user=$blog->users->first();
        $param=[
            'email'=>$user->email,
            'password'=>$user->password
        ];

        $code=(new DeleteBlogService())->DeleteBlog($blog,$user,$param);
                                                    
        $this->assertEquals(200,$code);
    }

}
