<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\Notification;
use App\Models\User;
use App\Services\Notifications\NotificationsService;
use Tests\TestCase;
use Illuminate\Support\Str;


class NotificationsTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | Notifications Test
    |--------------------------------------------------------------------------|
    | This class tests Notifications services
    |
   */

    /**
     *  
     *  GetNotifications: testing if the request is valid
     * 
     */

    public function test_GetNotifications_Success()
    {
        $blog=Blog::take(1)->first();
        $user=$blog->users->first();

        [$code,$dummy]=(new NotificationsService())->GetNotifications($blog->blog_name,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  GetNotifications: testing if target blog isn't valid
     * 
     */

    public function test_GetNotifications_NotFound()
    {
        $blogName=null;
        $user=User::take(1)->first();

        [$code,$dummy]=(new NotificationsService())->GetNotifications($blogName,$user);
                                                    
        $this->assertEquals(404,$code);
    }

    /**
     *  
     *  SeeNotification: testing if the request is valid
     * 
     */

    public function test_SeeNotification_Success()
    {
        $noti=Notification::take(1)->first();
        $user=Blog::find($noti->to_blog_id)->users->first();

        $code=(new NotificationsService())->SeeNotification($noti->id,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  SeeNotification: testing if the notification is not found
     * 
     */

    public function test_SeeNotification_NotFound()
    {
        $notiId=null;
        $user=User::take(1)->first();

        $code=(new NotificationsService())->SeeNotification($notiId,$user);
                                                    
        $this->assertEquals(404,$code);
    }

    /**
     *  
     *  SeeNotification: testing if not allowed
     * 
     */

    public function test_SeeNotification_Fobidden()
    {
        $noti=Notification::take(1)->first();

        $usersIds=Blog::find($noti->to_blog_id)->users()->pluck('user_id')->toArray();
        $user=User::whereNotIn('id',$usersIds)->first();

        $code=(new NotificationsService())->SeeNotification($noti->id,$user);
                                                    
        $this->assertEquals(403,$code);
    }
    
    /**
     *  
     *  GetUnseens: testing if the request is valid
     * 
     */

    public function test_GetUnseens_Success()
    {
        $user=User::take(1)->first();

        $count=(new NotificationsService())->GetUnseens($user);
                                                    
        $this->assertIsInt($count);
    }

    /**
     *  
     *  StoreToken: testing if the request is valid
     * 
     */

    public function test_StoreToken_Success()
    {
        $user=User::take(1)->first();

        $code=(new NotificationsService())->StoreToken($user,Str::random(10));
                                                    
        $this->assertIsInt(200,$code);
    }


    /**
     *  
     *  GetLastNdaysActivity: testing if the request is valid
     * 
     */

    public function test_GetLastNdaysActivity_Success()
    {
        $lastNdays=7;
        $blogName=Blog::take(1)->first()->blog_name;

        [$code,$dummy]=(new NotificationsService())->GetLastNdaysActivity($lastNdays,$blogName);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  GetLastNdaysActivity: testing if the blog doesnot exist
     * 
     */

    public function test_GetLastNdaysActivity_NotFound()
    {
        $lastNdays=7;
        $blogName=null;

        [$code,$dummy]=(new NotificationsService())->GetLastNdaysActivity($lastNdays,$blogName);
                                                    
        $this->assertEquals(404,$code);
    }


}
