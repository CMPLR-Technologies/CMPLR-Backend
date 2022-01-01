<?php

namespace App\Services\Inbox;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\Post;
use App\Models\Posts;
use Illuminate\Database\Eloquent\Collection;
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
     * implements the logic of getting inbox of a user
     * @param User $user
     * @return array
     */
    public function GetInbox($user)
    {
        // get ids of of the blogs in which the user is a member
        $blogsIds=  $user
                    ->realBlogs()
                    ->pluck('blog_id')
                    ->toArray();

        // user entire inbox
        $inbox= Posts::whereIn('blog_id',$blogsIds)
                ->where('post_ask_submit','ask')
                ->orwhere('post_ask_submit','submit')
                ->orderBy('created_at',"DESC")
                ->paginate(Config::PAGINATION_LIMIT);

        return [200,$inbox];
    }

}
