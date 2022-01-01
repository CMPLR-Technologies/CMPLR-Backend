<?php

namespace App\Services\Inbox;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class GetBlogInboxService{

    /*
    |--------------------------------------------------------------------------
    | GetBlogInbox Service
    |--------------------------------------------------------------------------
    | This class handles the logic of GetBlogInbox function
    |
   */


    /**
     * implements the logic of getting inbox of a blog
     * @param User $user
     * @param string $blogName
     * @return array
     */
    public function GetBlogInbox($blogName,$user)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();

        if($blog==null)
            return [404,null];

        //check if the authenticated user is a member in this blog
        if($blog->users->contains('id',$user->id) == false)
            return [403,null];

        // get inbox of the blog
        $inbox= $blog
                ->posts()
                ->where('post_ask_submit','ask')
                ->orwhere('post_ask_submit','submit')
                ->orderBy('created_at',"DESC")
                ->paginate(Config::PAGINATION_LIMIT);

        return [200,$inbox];
    }

}
