<?php

namespace App\Services\Inbox;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\Post;
use App\Models\Posts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeleteInboxService{

    /*
    |--------------------------------------------------------------------------
    | DeleteInbox Service
    |--------------------------------------------------------------------------
    | This class handles the logic of DeleteInbox function
    |
   */

    /**
     * implements the logic of deleting the inbox of a user
     * @param User $user
     * @return array
     */
    public function DeleteInbox($user)
    {
        // get ids of of the blogs in which the user is a member
        $blogsIds=  $user
                    ->realBlogs()
                    ->pluck('blog_id')
                    ->toArray();

        // delete entire inbox
        Posts:: whereIn('blog_id',$blogsIds)
                ->where('post_ask_submit','ask')
                ->orwhere('post_ask_submit','submit')
                ->delete();

        return 200;
    }

    /**
     * implements the logic of deleting the inbox of a blog
     * @param User $user
     * @param string $blogName
     * @return array
     */
    public function DeleteBlogInbox($blogName,$user)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();

        if($blog==null)
            return 404;

        //check if the authenticated user is a member in this blog
        if($blog->users->contains('id',$user->id) == false)
            return 403;

        // get inbox of the blog
        $blog
            ->posts()
            ->where('post_ask_submit','ask')
            ->orwhere('post_ask_submit','submit')
            ->delete();

        return 200;
    }

}
