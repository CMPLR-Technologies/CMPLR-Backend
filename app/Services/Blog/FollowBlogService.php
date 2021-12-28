<?php

namespace App\Services\Blog;

use App\Models\Blog;
use App\Models\BlogSettings;
use App\Models\Follow;
use App\Models\User;
use App\Services\Block\BlockService;
use Illuminate\Support\Facades\DB;

class FollowBlogService{


    public function FollowBlog($blog,$user)
    {
        //check if the blog doesn't exist
        if($blog==null)
            return 404;

        //check if the user is already following the blog
        if($blog->followedBy($user))
            return 409;
        
        //check if blocked
        if((new BlockService())->isBlocked($blog->id,$user->primary_blog_id))
            return 403;

        //create a follow through the relation
        $blog->Followers()->create([
            'user_id'=>$user->id
        ]);

        return 200;
    }

    /**
     * This Function Get Blog using blog_name
     * @param string $blog_name
     * @return Blog 
     */
    public function GetBlog(string $blog_name)
    {
        try {
            $blog = Blog::where('blog_name',$blog_name)->first();
        } catch (\Throwable $th) {
            return null;
        }
        return $blog;
    }

    /**
     * This Funtion Get Followers for specific Blog
     */
    public function GetFollowersID(int $blog_id)
    {
        try {
            $followers_id = DB::table('follows')->where('blog_id',$blog_id)->pluck('user_id');
        } catch (\Throwable $th) {
            return null;
        }
        return $followers_id;
    }

    /**
     * This Funtion Get Followers for specific Blog
     */
    public function GetFollowersInfo($followers_id)
    {
        // if there is no followers return empty array
        if(!$followers_id)
            return [];
        $followers_info = array();
        try {
            foreach ($followers_id as $id) {
                $pid = User::where('id',$id)->first()->primary_blog_id;
                $followers_data1 = Blog::where('id', $pid )->first()->only(['id','blog_name','title']);
                $followers_data2 = BlogSettings::where('id', $pid )->first()->only(['avatar']);
                $followers_data = array_merge($followers_data1,$followers_data2);
                array_push($followers_info,$followers_data);
            }
        } catch (\Throwable $th) {
            // incase of database exception
            throw $th;
        }
        return $followers_info;
    }

}
