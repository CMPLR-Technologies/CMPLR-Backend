<?php

namespace Tests\Unit;

use App\Services\Blog\FollowBlogService;
use App\Models\Blog;
use App\Models\Follow;
use App\Models\User;
use Tests\TestCase;

class FollowBlogTest extends TestCase
{
    //testing if wrong parameters were sent
    public function test_InvalidData()
    {
        $blog=null;
        $user=null;
        
        $code=(new FollowBlogService())->FollowBlog($blog,$user);
        
        $this->assertEquals(404,$code);
    }

    //testing if the user is already following the blog
    public function test_Conflict()
    {
        $follow=Follow::take(1)->first();
        $blog=Blog::find($follow->blog_id);
        $user=User::find($follow->user_id);
        
        $code=(new FollowBlogService())->FollowBlog($blog,$user);
        
        $this->assertEquals(409,$code);
    }

    //testing if the request is valid
    public function test_Success()
    {
        $follow=Follow::take(1)->first();
        $blog=Blog::find($follow->blog_id);
        $user=User::find($follow->user_id);
        $follow->delete();
        
        $code=(new FollowBlogService())->FollowBlog($blog,$user);
        
        $this->assertEquals(200,$code);
    }

}
