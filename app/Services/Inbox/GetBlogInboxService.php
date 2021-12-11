<?php

namespace App\Services\Inbox;

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
     * implements the logic of getting blog inbox
     * 
     * @return array
     */
    public function GetBlogInbox($blogName)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();

        // get asks of the blog
        $asks=$blog->posts()->where('post_ask_submit','ask')->get();

        return [200,$asks];
    }

}
