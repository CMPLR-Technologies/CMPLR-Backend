<?php

namespace App\Services\Blog;

use App\Models\Blog;

class BlogService
{
    /**
     * GET Random Blogs
     *
     * @param 
     * 
     * @return Blogs
     */
    public function GetRandomBlogs()
    {
        $blogs = Blog::where('public', '=', true)->inRandomOrder()->paginate(4);
        if (!$blogs)
            return null;
        return $blogs;
    }
}