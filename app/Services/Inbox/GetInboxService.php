<?php

namespace App\Services\Inbox;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class GetInboxService{

    /*
    |--------------------------------------------------------------------------
    | GetInbox Service
    |--------------------------------------------------------------------------
    | This class handles the logic of GetInbox function
    |
   */

    /**
     * implements the logic of getting inbox
     * 
     * @return array
     */
    public function GetInbox()
    {
        // get blogs of the user
        $blogs=auth()->user()->realBlogs;

        // get asks of each blog
        $asks=[];

        // get asks of each blog
        foreach($blogs as $blog)
        {    
            // get asks of $blog
            $blogAsks=$blog->posts()->where('post_ask_submit','ask')->get();

            // turn the collection into an array
            $blogAsks=$blogAsks->toArray();

            // push the blog asks into the total asks
            $asks=array_merge($asks,$blogAsks);
        }

        return [200,$asks];
    }

}
