<?php

namespace App\Services\User;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Follow;
use App\Models\Post;
use App\Models\PostNotes;
use App\Models\Posts;
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
    public function GetBlogsData(int $userId)
    {
        $blogsIds= BlogUser::where('user_id',$userId)->pluck('blog_id');
        
        $blogs = Blog::whereIn('id', $blogsIds)->get();
        return $blogs;
    }


    /**
     * Get posts id that the user likes
     *
     * @param int $user_id
     * 
     * @return array
     */
    public function GetLikes(int $userId)
    {
        $likes = PostNotes::where('user_id',$userId)->where('type','=','like')->pluck('post_id');
        if(!$likes)
            return null;
        return $likes;
    }

    /**
     * this function is responsible for getting user follwing count
     * @param int $user_id
     * @return int
     */
    public function GetUserFollowing(int $userId)
    {
       return  DB::table('follows')->where('user_id',$userId)->count();
    }


    /**
     * This function responsible for get posts of user
     * @param User $user
     * @return integer
     */
    public function GetUserPosts(User $user)
    {
        $userBlogs = $user->blogs()->pluck('blog_id');
        //dd($user_blogs);
        $postsCount = Post::whereIn('blog_id',$userBlogs)->count();
        return $postsCount;
    }

    /**
     * This function responsible for update user theme 
     * @param integer $user_id
     * @param string $theme
     * 
     * @return object
     */
    public function UpdateUserTheme(int $userId,string $theme)
    {
        try {
            $check = User::where('id', $userId)->update(array('theme' => $theme));
        } catch (\Throwable $th) {
            return null;
        }
        return $check;
    }

    /**
     * This function is responsible for return the proper posts for dashboard
     * 
     * @param array $user_blogs
     * @param array $followed_blogs_id
     * @return Posts $posts
     */
    public function GetDashBoardPosts($userBlogs,$followedBlogsId)
    {
        $Posts = Posts::whereIn('blog_id', $followedBlogsId)->orWhereIn('blog_id', $userBlogs)->orderBy('updated_at', 'DESC')->paginate(Config::PAGINATION_LIMIT);
        // if their is no posts return random posts
        if(count($Posts) == 0)
        {
            $Posts = Posts::orderBy('updated_at', 'DESC')->paginate(Config::PAGINATION_LIMIT);
        }
        return $Posts;
    }

}
