<?php

namespace Tests\Unit;

use App\Services\Blog\CreateBlogService;
use App\Models\Blog;
use App\Models\User;
use Tests\TestCase;

class CreateBlogTest extends TestCase
{
    //testing if wrong parameters were sent
    public function test_InvalidData()
    {
        $blog=Blog::take(1)->first();
        $user=User::take(1)->first();        

        $code=(new CreateBlogService())->CreateBlog(['url'=>$blog->url],$user);
                                                    
        $this->assertEquals(422,$code);
    }

    //testing if the request is valid
    public function test_Success()
    {
        $user=User::take(1)->first();        
        $param=['url'=>'url3','title'=>'title1','privacy'=>false,'password'=>null];

        $code=(new CreateBlogService())->CreateBlog($param,$user);
                                                    
        $this->assertEquals(201,$code);
    }

}
