<?php

namespace App\Services\User;

use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Follow;
use App\Models\Post;
use App\Models\PostNotes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{


    /**
     * get Authenticated User.
     *
     * @return User
     */
    public function GetAuthUser()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Get User data needed
     *
     * @param User $user
     * 
     * @return object
     */
    public function GetUserData(user $user)
    {
        $data = User::where('id', $user->id)->get()->first();
       return $data;
    }

    /**
     * Get blogs data needed
     * return array of blogs 
     *
     * @param int $user_id
     * 
     * @return array
     */
    public function GetBlogsData(int $user_id)
    {
        $blogs_ids= BlogUser::where('user_id',$user_id)->pluck('blog_id');
        
        $blogs = Blog::whereIn('id', $blogs_ids)->get();
        return $blogs;
    }


    /**
     * Get posts id that the user likes
     *
     * @param int $user_id
     * 
     * @return array
     */
    public function GetLikes(int $user_id)
    {
        $likes = PostNotes::where('user_id',$user_id)->where('type','=','like')->pluck('post_id');
        if(!$likes)
            return null;
        return $likes;
    }

    /**
     * this function is responsible for getting user follwing count
     * @param int $user_id
     * @return int
     */
    public function GetUserFollowing(int $user_id)
    {
       return  DB::table('follows')->where('user_id',$user_id)->count();
    }


    /**
     * 
     */
    public function GetUserPosts(User $user)
    {
        $user_blogs = $user->blogs()->pluck('blog_id');
        //dd($user_blogs);
        $posts_count = Post::whereIn('blog_id',$user_blogs)->count();
        return $posts_count;
    }


    public function UpdateUserTheme(int $user_id,string $theme)
    {
        try {
            $check = User::where('id', $user_id)->update(array('theme' => $theme));
        } catch (\Throwable $th) {
            return null;
        }
        return $check;
    }

}
