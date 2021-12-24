<?php

namespace App\Services\Notifications;

use App\Models\Blog;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Not;

class NotificationsService{

    /*
    |--------------------------------------------------------------------------
    | Notifications Service
    |--------------------------------------------------------------------------
    | This class handles the logic of NotificationsController
    |
   */

    /**
     * implements the logic of creating a notification
     * 
     * @return void
     */
    public function CreateNotification($from_blog_id,$to_blog_id,$type,$post_ask_answer_id)
    {
        Notification::create([
            'from_blog_id'=>$from_blog_id,
            'to_blog_id'=>$to_blog_id,
            'type'=>$type,
            'post_ask_answer_id'=>$post_ask_answer_id,
            'date'=>Carbon::now()->toRfc850String()
        ]);
    }

    /**
     * implements the logic of deleting a notification
     * 
     * @return void
     */
    public function DeleteNotification($from_blog_id,$to_blog_id,$type,$post_ask_answer_id)
    {
        Notification::where('from_blog_id',$from_blog_id)
                    ->where('to_blog_id',$to_blog_id)
                    ->where('type',$type)
                    ->where('post_ask_answer_id',$post_ask_answer_id)
                    ->delete();
    }

    /**
     * implements the logic of getting notifications
     * 
     * @return array
     */
    public function GetNotifications($blogName,$user)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();

        if($blog==null)
            return [404,null];

        //check if the authenticated user is a member in this blog
        if($blog->users->contains('id',$user->id) == false)
            return [403,null];

        //get notifications of the blog
        $notis=Notification::where('to_blog_id',$blog->id)
                            ->latest()
                            ->get();

        return [200,$notis];
    }

    /**
     * implements the logic of seeomg a notification
     * 
     * @return int
     */

    public function SeeNotification($notificationId,$user)
    {
        //get target blog
        $noti=Notification::find($notificationId);

        if($noti==null)
            return 404;

        $blog=Blog::find($noti->to_blog_id);

        //check if the authenticated user is a member in this blog
        if($blog->users->contains('id',$user->id) == false)
            return 403;

        //update the notification to make seen
        $noti->seen=true;
        $noti->update();

        return 200;
    }

}
