<?php

namespace App\Services\Notifications;

use App\Models\Blog;
use App\Models\Notification;
use Carbon\Carbon;

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
    public function CreateNotification($fromBlogId,$toBlogId,$type,$postAskAnswerId)
    {
        //create the notification in the data base
        Notification::create([
            'from_blog_id'=>$fromBlogId,
            'to_blog_id'=>$toBlogId,
            'type'=>$type,
            'post_ask_answer_id'=>$postAskAnswerId,
            'date'=>Carbon::now()->toRfc850String()
        ]);

        //send a push notification to the corresponding users

        //get tokens of the users who are members of the target blog
        $usertokens=Blog::find($toBlogId)
                ->users()
                ->pluck('fcm_token')
                ->toArray();

        //build the corresponding message
        $message="notification: {$fromBlogId} {$type}ed your {$toBlogId}";

        //send the notification
        NotificationsService::SendNotification($message,$usertokens);
    }

    /**
     * implements the logic of deleting a notification
     * 
     * @return void
     */
    public function DeleteNotification($fromBlogId,$toBlogId,$type,$postAskAnswerId)
    {
        Notification::where('from_blog_id',$fromBlogId)
                    ->where('to_blog_id',$toBlogId)
                    ->where('type',$type)
                    ->where('post_ask_answer_id',$postAskAnswerId)
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
     * implements the logic of seeing a notification
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

    /**
     * implements the logic of getting the number of unseen notifications
     * 
     * @return int
     */

    public function GetUnseens($user)
    {
        //get blog ids of the user
        $blogIds=$user
                ->realBlogs()
                ->pluck('blog_id')
                ->toArray();
        
        //get the number of unseen notifications that were sent to any of the blogs that 
        //belongs to the user
        $count=Notification::whereIn('to_blog_id',$blogIds)
                            ->where('seen','false')
                            ->count();
        
        return $count;
    }

    /**
     * implements the logic of storing user's firebase token
     * 
     * @return int
     */

    public function StoreToken($user,$token)
    {
        //update user record with the new FCM token
        $user->fcm_token=$token;
        $user->update();

        return 200;
    }

    /**
     * implements the logic of sending a notification to a certain blog
     * 
     * @return int
     */

    public function SendNotification($message,$targetTokens)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAAZADeAGM:APA91bFx2JPNCF5g_0YImp2YlgGlUANPGhIB1fVhcIO4GWAih6we8kyYjaaVMgzR89uA7wdS48g6Nq-If8KvSNjjLHZC4orWkz1AjryhGk2ANYk9x9M7M1JWQ4kms_ZDqPXF5l_6K1so';
  
        $data = [
            "registration_ids" => $targetTokens,
            "notification" => [
                "title" => 'notification',
                "body" => $message,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        

        // Close connection
        curl_close($ch);

        // FCM response
        // dd($result);        
    }


}
