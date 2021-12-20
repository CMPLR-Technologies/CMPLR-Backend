<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Blog;
use App\Models\User;
use App\Services\Ask\DeleteAskService;
use Tests\TestCase;
use Illuminate\Support\Str;

class DeleteAskTest extends TestCase
{

    /*
    |--------------------------------------------------------------------------
    | DeleteAsk Test
    |--------------------------------------------------------------------------|
    | This class tests DeleteAsk 
    |
   */


    //testing if ask is not found
    public function test_NotFound()
    {
        $askId=-1;
        $user=null;

        $code=(new DeleteAskService())->DeleteAsk($askId,$user);
                                                    
        $this->assertEquals(404,$code);
    }
    
    //test if the user is not a member of the blog
    public function test_Forbidden()
    {
        //get an ask
        $ask=Post::all()->where('post_ask_submit','ask')->first();
        
        //get users that are member of the blog of this ask
        $usersId=Blog::find($ask->blog_id)->users()->pluck('user_id')->toArray();
        
        //get a user which is not a member of the blog
        $user=User::all()->whereNotIn('id',$usersId)->first();

        $code=(new DeleteAskService())->DeleteAsk($ask->id,$user);

        $this->assertEquals(403,$code);
    }

    //testing if the request is valid
    public function test_Success()
    {
        $ask=Post::all()->where('post_ask_submit','ask')->first();

        $user=Blog::find($ask->blog_id)->users()->first();
        
        $code=(new DeleteAskService())->DeleteAsk($ask->id,$user);
                                                    
        $this->assertEquals(202,$code);
    }


}
