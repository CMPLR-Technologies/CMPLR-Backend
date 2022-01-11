<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use App\Services\Blog\CreateBlogService;
use Tests\TestCase;
use Illuminate\Support\Str;

class CreateBlogTest extends TestCase
{
    //testing if wrong parameters were sent
    public function test_InvalidData()
    {
        $blog=Blog::take(1)->first();
        $user=User::take(1)->first();        

        $code=(new CreateBlogService())->CreateBlog(['blogName'=>$blog->blog_name],$user);
                                                    
        $this->assertEquals(422,$code);
    }

    //testing if the request is valid
    public function test_Success()
    {
        $user=User::take(1)->first();        

        $param=[
            'blogName'=>Str::random(20),
            'title'=>Str::random(20),
            'privacy'=>false,
            'password'=>null
        ];

        $code=(new CreateBlogService())->CreateBlog($param,$user);
                                                    
        $this->assertEquals(201,$code);
    }

}
