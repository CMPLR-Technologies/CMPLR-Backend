<?php

namespace App\Services\Posts;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\Post;
use App\Models\Posts;
use App\Models\PostTags;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsService
{



    /**
     * Get Blog from BlogName
     *
     * @param string $blog_name
     * 
     * @return object
     */
    public function GetBlogData(string $blogName)
    {

        $blog = Blog::where('blog_name', $blogName)->first();

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
    public function GetPostData(int $postId)
    {
        $post = Posts::where('id', $postId)->first();
        return $post;
    }

    /**
     * GET Random Post
     *
     * @param $userBlogs
     * 
     * @return Posts
     */
    public function GetRandomPost($userBlogs)
    {
        $post = Posts::where('state', '=', 'publish')->whereNotIn('blog_id',$userBlogs)->inRandomOrder()->limit(1)->first();
        if (!$post)
            return null;
        return $post;
    }

    /**
     * GET Random Posts
     *
     * @param 
     * 
     * @return Posts
     */
    public function GetRandomPosts()
    {
        $posts = Posts::where('state', '=', 'publish')->inRandomOrder()->paginate(Config::PAGINATION_LIMIT);
        if (!$posts)
            return null;
        return $posts;
    }

    /**
     * This Function retrieve PostData needed
     * @param int $blog_id
     *@return Posts
     */
    public function MiniViewPostData(int $blogId)
    {
        $posts = Posts::select('id', 'content')->where('blog_id', $blogId)->get();
        return $posts;
    }

    /**
     * This function is responsible for check if this blog is blocked by me
     */
    

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
        // check if the this blog is primary
        if( $blog->users()->first())
            $data1['is_primary'] = $blog->users()->first()->primary_blog_id == $blog->id;
        else 
            $data1['is_primary'] = false; 
        $data1['description'] = $blog->settings->description;
        $data1['is_followed'] = $blog->isfollower();
        $data1['is_blocked'] = $blog->IsBlocked();
        return $data1;
    }

  
    /**
     * This function for MiniProfileview 
     * get 3 images of different posts of blog
     * @param array $posts
     * @return array
     */
    public function GetViews($posts)
    {
        $views = [];
        $size = 0;
        $imgString = '<img src=';
        $removed = '<img src="';
        // loop over posts
        foreach ($posts as $post) {
            // check that post has image
            if (strpos($post['content'], $imgString) !== false) {
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
                    if ($size == 3)
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
        $posts = Posts::wherein('id', $postsTags->pluck('post_id'))->orderBy('date', 'DESC')->paginate(Config::PAGINATION_LIMIT);
        $posts->tag = $tag;
        return $posts;
    }

    /**
     * Getting photo Post with tag 
     * 
     * @param $tag 
     * 
     * @return $post
     * 
     */
    public function GetPostWithTagPhoto ($tag)
    {
        $postsTags = PostTags::where('tag_name', $tag)->orderBy('created_at', 'DESC')->get();
        $post = Posts::wherein('id', $postsTags->pluck('post_id'))->where('type', 'photos')->first();
        return $post ;

    }
    /**
     * this function responsible for update post
     * @param Posts $post
     * @param array $data
     * 
     * @return Posts
     */
    public function UpdatePost ($post,$data)
    {
        try {
            $is_updated =  $post->update($data);;
        } catch (\Throwable $th) {
            return null;
        }
        return  $is_updated;
    }

    /**
     * This function used to delete Post
     * 
     */
    public function DeletePost(Posts $post)
    {
        try {
            $is_deleted = $post->delete();
        } catch (\Throwable $th) {
            return null;
        }
        return $is_deleted;
    }


    /**
     * this function is responsible for get blog by blog_name
     * @param string $blog_name
     * @return Blog
     */
    public function GetBlogByName($blogName)
    {
        $blog = Blog::where('blog_name', $blogName)->first();
        return $blog;
    }
    /**
     * this function responsible for get posts by blog name
     * @param int $blog_id
     * @return Posts 
     */
    public function GetPostsOfBlog(int $blogId)
    {
        if(auth('api')->check())
        {
            $user = auth('api')->user();
            if( (!!DB::table('follows')->where('user_id',$user->id)->where('blog_id',$blogId)->first()) || (!!BlogUser::where('user_id',$user->id)->where('blog_id',$blogId)->first()) )
                $posts = Posts::where('blog_id', $blogId)->orderBy('updated_at', 'DESC')->paginate(Config::PAGINATION_LIMIT);
            else 
                 $posts =  Posts::where('blog_id', $blogId)->where('state','=','publish')->orderBy('updated_at', 'DESC')->paginate(Config::PAGINATION_LIMIT);
        }
        else
        {
            $posts =  Posts::where('blog_id', $blogId)->where('state','=','publish')->orderBy('updated_at', 'DESC')->paginate(Config::PAGINATION_LIMIT);
        }
        return $posts;
    }
}