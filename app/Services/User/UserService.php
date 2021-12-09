<?php

namespace App\Services\User;

use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $data = User::where('id', $user->id)->get()->first()->only([
            'firstname', 'lastname','default_post_format',
           'following_count', 'likes_count'
       ]);
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
        
        $blogs = array();
        foreach($blogs_ids as $id){
            array_push($blogs,Blog::where('id',$id)->first()->only(['id','name','title','url','public','followers']));
        }
        return $blogs;
    }

}
