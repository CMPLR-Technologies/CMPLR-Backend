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
     * implements the logic of Deleting inbox
     * 
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

}
