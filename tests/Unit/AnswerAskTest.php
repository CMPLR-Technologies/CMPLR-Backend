<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Blog;
use App\Models\User;
use App\Services\Ask\AnswerAskService;
use Tests\TestCase;

class AnswerAskTest extends TestCase
{

    /*
    |--------------------------------------------------------------------------
    | AnswerAsk Test
    |--------------------------------------------------------------------------|
    | This class tests AnswerAsk 
    |
   */


    //testing if ask is not found
    public function test_NotFound()
    {
        $askId=null;
        $user=null;
        $param=[
            'content'=>'<html></html>',
            'state'=>'draft'
        ];

        $code=(new AnswerAskService())->AnswerAsk($param,$askId,$user);
                                                    
        $this->assertEquals(404,$code);
    }
    
    //test if the user is not a member of the blog
    public function test_Forbidden()
    {
        $param=[
            'content'=>'<html></html>',
            'state'=>'draft'
        ];

        //get an ask
        $ask=Post::where('post_ask_submit','ask')->first();
        
        //get users that are member of the blog of this ask
        $usersId=Blog::find($ask->blog_id)->users()->pluck('user_id')->toArray();
        
        //get a user which is not a member of the blog
        $user=User::whereNotIn('id',$usersId)->first();

        $code=(new AnswerAskService())->AnswerAsk($param,$ask->id,$user);

        $this->assertEquals(403,$code);
    }

    //testing if the request is valid
    public function test_Success()
    {
        $param=[
            'content'=>'<html></html>',
            'state'=>'draft'
        ];

        $ask=Post::where('post_ask_submit','ask')->first();

        $user=Blog::find($ask->blog_id)->users()->first();
        
        $code=(new AnswerAskService())->AnswerAsk($param,$ask->id,$user);
                                                    
        $this->assertEquals(200,$code);
    }


}
