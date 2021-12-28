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
       // try {
            $post = Posts::create($data);
            return $post;
        //} catch (\Throwable $th) {
            return null;
        //}
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
     * This Function retrieve PostData needed
     * @param int $blog_id
     *@return Posts
     */
    public function MiniViewPostData(int $blog_id)
    {
        $posts = Posts::select('id', 'content')->where('blog_id', $blog_id)->get();
        // ->whereIn('type', ['photos', 'mixed'])->get();
        return $posts;
    }

    /**
     * This Function retrieve blogsdata needed
     * @param int $blog_id
     *@return Posts
     */

    public function MiniViewBlogData(Blog $blog)
    {
        $data1['blog_name'] = $blog->blog_name;
        $data1['avatar'] = $blog->settings->avatar;
        $data1['title'] = $blog->title;
        $data1['header_image'] = $blog->settings->header_image;
        $data1['is_primary'] = $blog->users()->first()->primary_blog_id == $blog->id;
        //dd($data1['is_primary'] );
        // TODO: 
        $data1['desciption'] = 'hossam el gamd';
        return $data1;
    }

    public function GetViews($posts)
    {
        $views = [];
        $size = 0;
        $img_string = '<img src=';
        $removed = '<img src="';
        // loop over posts
        foreach ($posts as $post) {
            // check that post has image
            if (strpos($post['content'], $img_string) !== false) {
                // regex to get all images in array
                preg_match_all('/<img[^>]+>/i', $post['content'], $result);
                // check that image array is not empty
                if (!empty($result)) {
                    // get link from image tag
                    $s = substr($result[0][0], 0, -2);
                    $link = str_ireplace($removed, "", $s);
                    // set response
                    $data['link'] = $link;
                    $data['post_id'] = $post['id'];
                    $views[] = $data;
                    $size += 1;
                    // retrieve only 3 images
                    if($size == 3)
                        break;      
                }
            }

   
        }
        return $views;
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
