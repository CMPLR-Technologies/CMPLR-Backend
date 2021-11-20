<?php

namespace Tests\Unit;

use App\Services\Blog\DeleteBlogService;
use App\Models\Blog;
use App\Models\User;
use Tests\TestCase;

class DeleteBlogTest extends TestCase
{
    public function test_InvalidData()
    {
        $blog=Blog::take(1)->first();
        $user=User::find($blog->Users->where('full_privileges',true)->first()->user_id);
        $param=['email'=>'00','password'=>'00'];

        $code=(new DeleteBlogService())->DeleteBlog($blog,$user,$param);
                                                    
        $this->assertEquals(403,$code);
    }

    public function test_Success()
    {
        $blog=Blog::take(1)->first();
        $user=User::find($blog->Users->where('full_privileges',true)->first()->user_id);
        $param=['email'=>$user->email,'password'=>$user->password];

        $code=(new DeleteBlogService())->DeleteBlog($blog,$user,$param);
                                                    
        $this->assertEquals(200,$code);
    }

}
