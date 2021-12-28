<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Inbox\DeleteInboxService;
use App\Services\Inbox\GetBlogInboxService;
use App\Services\Inbox\GetInboxService;
use Tests\TestCase;


class InboxTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | Inbox Test
    |--------------------------------------------------------------------------|
    | This class tests Inbox services
    |
   */

    /**
     *  
     *  GetInbox: testing if the request is valid
     * 
     */

    public function test_GetInbox_Success()
    {
        $user=User::take(1)->first();

        [$code,$dummy]=(new GetInboxService())->GetInbox($user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  DeleteInbox: testing if the request is valid
     * 
     */

    public function test_DeleteInbox_Success()
    {
        $user=User::take(1)->first();

        $code=(new DeleteInboxService())->DeleteInbox($user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  GetBlogInbox: testing if the request is valid
     * 
     */

    public function test_GetBlogInbox_Success()
    {
        $user=User::take(1)->first();
        $blogName=$user->realBlogs->first()->blog_name;

        [$code,$dummy]=(new GetBlogInboxService())->GetBlogInbox($blogName,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  GetBlogInbox: testing if target blog is not found
     * 
     */

    public function test_GetBlogInbox_NotFound()
    {
        $user=User::take(1)->first();
        $blogName=null;

        [$code,$dummy]=(new GetBlogInboxService())->GetBlogInbox($blogName,$user);
                                                    
        $this->assertEquals(404,$code);
    }


    /**
     *  
     *  DeleteBlogInbox: testing if the request is valid
     * 
     */

    public function test_DeleteBlogInbox_Success()
    {
        $user=User::take(1)->first();
        $blogName=$user->realBlogs->first()->blog_name;

        $code=(new DeleteInboxService())->DeleteBlogInbox($blogName,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  DeleteBlogInbox: testing if target blog is not found
     * 
     */

    public function test_DeleteBlogInbox_NotFound()
    {
        $user=User::take(1)->first();
        $blogName=null;

        $code=(new DeleteInboxService())->DeleteBlogInbox($blogName,$user);
                                                    
        $this->assertEquals(404,$code);
    }



}
