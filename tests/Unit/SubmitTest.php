<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use App\Services\Submit\SubmitService;
use Tests\TestCase;

class SubmitTest extends TestCase
{

    /*
    |--------------------------------------------------------------------------
    | submit Test
    |--------------------------------------------------------------------------|
    | This class tests submit services
    |
   */

    /**
     *  
     *  CreateSubmit: testing if the request is valid
     * 
     */

    public function test_CreateSubmit_Success()
    {
        $blogName=Blog::take(1)->first()->blog_name;
        $user=User::take(1)->first();
        $param=[
            'mobile'=>'0',
            'content'=>'{"photo":"p1"}',
            'type'=>'photo'
        ];

        $code=(new SubmitService())->CreateSubmit($param,$blogName,$user);
                                                    
        $this->assertEquals(201,$code);
    }

    /**
     *  
     *  CreateSubmit: testing if blog name is not found
     * 
     */

    public function test_CreateSubmit_NotFound()
    {
        $blogName=null;
        $user=null;
        $param=[
            'mobile'=>'0',
            'content'=>'{"photo":"p1"}',
            'type'=>'photo'
        ];

        $code=(new SubmitService())->CreateSubmit($param,$blogName,$user);
                                                    
        $this->assertEquals(404,$code);
    }


    /**
     *  
     *  DeleteSubmit: testing if blog name is not found
     * 
     */

    public function test_DeleteSubmit_NotFound()
    {
        $submitId=null;
        $user=null;

        $code=(new SubmitService())->DeleteSubmit($submitId,$user);
                                                    
        $this->assertEquals(404,$code);
    }
    
    /**
     *  
     *  DeleteSubmit: test if the user is not a member of the blog
     * 
     */

    public function test_DeleteSubmit_Forbidden()
    {
        //get an submit
        $submit=Post::where('post_ask_submit','submit')->first();
        
        //get users that are member of the blog of this submit
        $usersId=Blog::find($submit->blog_id)->users()->pluck('user_id')->toArray();
        
        //get a user which is not a member of the blog
        $user=User::whereNotIn('id',$usersId)->first();

        $code=(new SubmitService())->DeleteSubmit($submit->id,$user);

        $this->assertEquals(403,$code);
    }

    /**
     *  
     *  DeleteSubmit:   testing if the request is valid
     * 
     */

    public function test_DeleteSubmit_Success()
    {
        $submit=Post::where('post_ask_submit','submit')->first();

        $user=Blog::find($submit->blog_id)->users()->first();
        
        $code=(new SubmitService())->Deletesubmit($submit->id,$user);
                                                    
        $this->assertEquals(202,$code);
    }

    /**
     *  
     *  PostSubmit:  testing if submit is not found
     * 
     */
  
    public function test_PostSubmit_NotFound()
    {
        $submitId=null;
        $user=null;
        $param=[
            'content'=>'<html></html>',
            'state'=>'draft'
        ];

        $code=(new SubmitService())->PostSubmit($param,$submitId,$user);
                                                    
        $this->assertEquals(404,$code);
    }
    
    /**
     *  
     *  PostSubmit:   test if the user is not a member of the blog
     * 
     */

    public function test_PostSubmit_Forbidden()
    {
        $param=[
            'content'=>'<html></html>',
            'state'=>'draft'
        ];

        //get an submit
        $submit=Post::where('post_ask_submit','submit')->first();
        
        //get users that are member of the blog of this submit
        $usersId=Blog::find($submit->blog_id)->users()->pluck('user_id')->toArray();
        
        //get a user which is not a member of the blog
        $user=User::whereNotIn('id',$usersId)->first();

        $code=(new SubmitService())->PostSubmit($param,$submit->id,$user);

        $this->assertEquals(403,$code);
    }

    /**
     *  
     *  PostSubmit:   testing if the request is valid
     * 
     */

    public function test_PostSubmit_Success()
    {
        $param=[
            'content'=>'<html></html>',
            'state'=>'draft'
        ];

        $submit=Post::where('post_ask_submit','submit')->first();

        $user=Blog::find($submit->blog_id)->users()->first();
        
        $code=(new SubmitService())->PostSubmit($param,$submit->id,$user);
                                                    
        $this->assertEquals(200,$code);
    }

}
