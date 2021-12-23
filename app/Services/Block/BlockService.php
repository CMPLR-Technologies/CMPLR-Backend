<?php

namespace App\Services\Block;

use App\Http\Misc\Helpers\Config;
use App\Models\Block;
use App\Models\Blog;

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
     * 
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

        return 200;
    }

    /**
     * implements the logic of unblocking a blog
     * 
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
     * implements the logic of getting the blocks of a blog
     * 
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

}
