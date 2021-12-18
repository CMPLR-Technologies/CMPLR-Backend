<?php

namespace Tests\Unit;

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
        $blogName='yousef';
        $request=[
            'mobile'=>'0',
            'content'=>'{"photo":"p1"}',
            'is_anonymous'=>'0',
            'layout'=>'{"photo1":"position"}',
            'format'=>'rich text'
        ];

        $code=(new CreateAskService())->CreateAsk($request,$blogName);
                                                    
        $this->assertEquals(201,$code);
    }

    //testing if blog name is not found
    public function test_NotFound()
    {
        $blogName=Str::random(5);
        $request=[
            'mobile'=>'0',
            'content'=>'{"photo":"p1"}',
            'is_anonymous'=>'0',
            'layout'=>'{"photo1":"position"}',
            'format'=>'rich text'
        ];

        $code=(new CreateAskService())->CreateAsk($request,$blogName);
                                                    
        $this->assertEquals(404,$code);
    }
    
}
