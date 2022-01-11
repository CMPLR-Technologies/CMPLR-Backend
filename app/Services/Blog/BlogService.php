<?php

namespace App\Services\Blog;

use App\Models\Blog;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;

class BlogService
{
    /**
     * GET Random Blogs for explore
     *
     * @param int $user_id
     * 
     * @return Blog
     * 
     * @author Abdullah Adel
     */
    public function GetRandomBlogs(int $user_id = null)
    {
        $filtered_blogs = [];

        if ($user_id) {
            $user_blogs = DB::table('blog_users')->where('user_id', $user_id)->pluck('blog_id')->toArray();
            $followed_blogs = DB::table('follows')->where('user_id', $user_id)->pluck('blog_id')->toArray();

            $filtered_blogs = array_merge($user_blogs, $followed_blogs);
        }

        $blogs = Blog::where('public', '=', 'true')->whereNotIn('id', $filtered_blogs)->inRandomOrder()->paginate(4);

        return $blogs;
    }
}