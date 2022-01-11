<?php

namespace App\Services\Blog;

use App\Models\Blog;
use App\Models\BlogSettings;
use App\Models\Follow;
use App\Models\User;
use App\Services\Block\BlockService;
use Illuminate\Support\Facades\DB;

class FollowBlogService{

    /**
     * implement the logic of following a blog
     * @param Blog $blog 
     * @param User $user
     * @return int
     */
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
     * @param array $followers_id
     * @return array
     */
    public function GetFollowersInfo($followersId)
    {
        // if there is no followers return empty array
        if(!$followersId)
            return [];
        $followers_info = array();
        try {
            foreach ($followersId as $id) {
                // get primary blog id of user 
                $pid = User::where('id',$id)->first()->primary_blog_id;
                // get the blog
                $blog = Blog::where('id', $pid )->first();
                // get the data needed for blogs
                $followersData1 = $blog ->only(['id','blog_name','title']);
                $followersData = array_merge($followersData1,['avatar' => $blog->settings->avatar],['is_followed'=>$blog->IsFollowerToMe()]);
                // merge data
                array_push($followers_info,$followersData);
            }
        } catch (\Throwable $th) {
            // incase of database exception
            throw $th;
        }
        return $followers_info;
    }

    /**
     * This function is used in get blogs id 
     * @param integer $user_id
     * @return array
     */
   public function GetBlogIds(int $userId)
   {
        $blog_ids = DB::table('follows')->where('user_id',$userId)->orderBy('created_at', 'DESC')->pluck('blog_id');
        return $blog_ids;
   }

   /**
    * this function is used for get followers from their id
    * @param array $followers_id
    * @return User
    */
   public function GetFollowers($followersId)
   {
        $users = User::whereIn('id',$followersId)->get();
        return $users;
   }

}
