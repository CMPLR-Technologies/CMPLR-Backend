<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use App\Services\Ask\CreateAskService;
use Tests\TestCase;
use Illuminate\Support\Str;

class CreateAskTest extends TestCase
{

    /*
    |--------------------------------------------------------------------------
    | CreateAsk Test
    |--------------------------------------------------------------------------|
    | This class tests CreateAsk 
    |
   */

    //testing if the request is valid
    public function test_Success()
    {
        $blogName=Blog::take(1)->first()->blog_name;
        $user=User::take(1)->first();
        $request=[
            'mobile'=>'0',
            'content'=>'{"photo":"p1"}',
            'is_anonymous'=>'0',
        ];

        $code=(new CreateAskService())->CreateAsk($request,$blogName,$user);
                                                    
        $this->assertEquals(201,$code);
    }

    //testing if blog name is not found
    public function test_NotFound()
    {
        $blogName=null;
        $user=null;
        $request=[
            'mobile'=>'0',
            'content'=>'{"photo":"p1"}',
            'is_anonymous'=>'0',
        ];

        $code=(new CreateAskService())->CreateAsk($request,$blogName,$user);
                                                    
        $this->assertEquals(404,$code);
    }
    
}
