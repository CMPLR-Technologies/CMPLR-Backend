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
     * implements the logic of getting blog inbox
     * 
     * @return array
     */
    public function GetBlogInbox($blogName)
    {
        //get target blog
        $blog=Blog::where('blog_name',$blogName)->first();

        if($blog==null)
            return [404,null];

        // get inbox of the blog
        $inbox= $blog
                ->posts()
                ->where('post_ask_submit','ask')
                ->orwhere('post_ask_submit','submit')
                ->paginate(Config::PAGINATION_LIMIT);

        return [200,$inbox];
    }

}
