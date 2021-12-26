<?php

namespace App\Services\Posts;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Posts;
use App\Models\PostTags;
use App\Models\Tag;
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
     * @return Post
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
        $post = Posts::where('id', $post_id)->first();
        return $post;
    }

    /**
     * GET Random Post
     *
     * @param 
     * 
     * @return Posts
     */
    public function GetRandomPost()
    {
        $post = Posts::where('state', '=', 'publish')->inRandomOrder()->limit(1)->first();
        if (!$post)
            return null;
        return $post;
    }

    /**
     * Add post Tags 
     * 
     * @param $postId
     * @param $postTags
     * 
     * @author Yousif Ahmed
     */
    public function AddPostTags($postId, $postTags)
    {
        foreach ($postTags as $tag) {

            try {
                Tag::create([
                    'name' => $tag,
                ]);
            } catch (\Throwable $th) {
            }
            try {
                PostTags::create([
                    'post_id' => $postId,
                    'tag_name' => $tag,
                ]);
            } catch (\Throwable $th) {

            }
        }
    }

    /**
     * Getting Posts with tag
     * 
     * @param $tag 
     * 
     * @return Posts
     * @author Yousif Ahmed
     */

    public function GetPostsWithTag($tag)
    {
        $postsTags = PostTags::where('tag_name', $tag)->orderBy('created_at', 'DESC')->get();
        $posts= Posts::wherein('id' , $postsTags->pluck('post_id'))->orderBy('date', 'DESC')->paginate(Config::PAGINATION_LIMIT);
        $posts->tag = $tag ;
       
        return $posts ;
    }
}
