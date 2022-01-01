<?php

namespace App\Services\Block;

use App\Http\Misc\Helpers\Config;
use App\Models\Block;
use App\Models\Blog;
use App\Models\Follow;

class BlockService{

    /*
    |--------------------------------------------------------------------------
    | Block Service
    |--------------------------------------------------------------------------
    | This class handles the logic of BlogBlockController
    |
   */


    /**
     * implements the logic of blocking a blog
     * @param string $blockName
     * @param string $blogName
     * @param User $user
     * @return int
     */
    public function BlockBlog($blockName,$blogName,$user)
    {
        //get the blogs
        $block=Blog::where('blog_name',$blockName)->first();
        $blog=Blog::where('blog_name',$blogName)->first();

        //check if the blogs exist
        if($blog==null || $block==null)
            return 404;

        //check if the authenticated user is authorized to block a blog
        $notAuthorized= $blog
                        ->users()
                        ->where('user_id',$user->id)
                        ->where('full_privileges', 1)
                        ->get()
                        ->isEmpty();

        if($notAuthorized)
            return 403;

        //check if the blog is already blocked
        if($blog->Blocks->contains('blocked_blog_id',$block->id))
            return 409;
        
        //create the block record
        $blog->Blocks()->create([
            'blocked_blog_id'=>$block->id
        ]);

        //remove the follow relation
        Follow::where('user_id',$user->id)
              ->where('blog_id',$block->id)
              ->delete();

        //get all the users in the blocked blog
        $blockedUsersIds=$block->users()->pluck('user_id')->toArray();
        
        //remove the follow relation
        Follow::whereIn('user_id',$blockedUsersIds)
              ->where('blog_id',$blog->id)
              ->delete();

        return 200;
    }

    /**
     * implements the logic of unblocking a blog
     * @param string $unblockName
     * @param string $blogName
     * @param User $user
     * @return int
     */
    public function UnblockBlog($unblockName,$blogName,$user)
    {
        //get blogs
        $unblock=Blog::where('blog_name',$unblockName)->first();
        $blog=Blog::where('blog_name',$blogName)->first();

        //check if blogs exist
        if($blog==null || $unblock==null)
            return 404;

        //check if user is authorized to unblock a blog
        $notAuthorized= $blog
                        ->users()
                        ->where('user_id',$user->id)
                        ->where('full_privileges', 1)
                        ->get()
                        ->isEmpty();

        if($notAuthorized)
            return 403;

        //check if blog is already not blocked
        if($blog->Blocks->contains('blocked_blog_id',$unblock->id)==false)
            return 409;

        //delete block record
        $blog->Blocks()->where('blocked_blog_id',$unblock->id)->delete();
        
        return 200;
    }

    /**
     * implements the logic of getting blocked blogs of a blog
     * @param string $blogName
     * @param User $user
     * @return int
     */
    public function GetBlogBlocks($blogName,$user)
    {
        //get blog
        $blog=Blog::where('blog_name',$blogName)->first()   ;

        //check if blog exists
        if($blog==null)
            return [404,null];

        //check if user is authorized to get blocks
        $notAuthorized= $blog
                        ->users()
                        ->where('user_id',$user->id)
                        ->where('full_privileges', 1)
                        ->get()
                        ->isEmpty();

        if($notAuthorized)
            return [403,null];
        
        //get the blocked blogs
        $blocks=$blog->BlockedBlogs()->paginate(Config::PAGINATION_LIMIT);

        return [200,$blocks];
    }

    /**
     * implements the logic of checking if two blogs are blocked
     * @param int $firstBlogId
     * @param int $secondBlogId
     * @return boolean
     */
    public function isBlocked($firstBlogId,$secondBlogId)
    {
        $blocked=Block::where('blog_id',$firstBlogId)
                      ->where('blocked_blog_id',$secondBlogId)
                      ->count();
        
        $blocked+=Block::where('blog_id',$secondBlogId)
                        ->where('blocked_blog_id',$firstBlogId)
                        ->count();

        if($blocked>0)
            return true;
        else 
            return false;
    }


    /**
     * implements the logic of deleting any blocks between two blogs 
     * @param int $firstBlogId
     * @param int $secondBlogId
     * @return boolean
     */
    public function noBlock($firstBlogId,$secondBlogId)
    {
        $blocked=Block::where('blog_id',$firstBlogId)
                      ->where('blocked_blog_id',$secondBlogId)
                      ->delete();
        
        $blocked+=Block::where('blog_id',$secondBlogId)
                        ->where('blocked_blog_id',$firstBlogId)
                        ->delete();

        if($blocked>0)
            return true;
        else 
            return false;
    }
}
