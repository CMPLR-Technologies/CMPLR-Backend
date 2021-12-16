<?php

namespace App\Services\Posts;

use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PostsService
{



    /**
     * Get Blog from BlogName
     *
     * @param string $blog_name
     * 
     * @return object
     */
    public function GetBlogData(string $blog_name)
    {

        $blog = Blog::where('blog_name', $blog_name)->first();

        return $blog;
    }

    /**
     * Insert post data in DataBase
     *
     * @param array $data
     * 
     * @return bool
     */
    public function createPost(array $data)
    {
        try {
           $post = Posts::create($data);
           return $post;
        } catch (\Throwable $th) {
            return null;
        }
    }

      /**
     * Insert post data in DataBase
     *
     * @param array $data
     * 
     * @return Posts
     */
    public function GetPostData(int $post_id)
    {
        $post = Posts::where('id',$post_id)->first();
        return $post;
    }


}
