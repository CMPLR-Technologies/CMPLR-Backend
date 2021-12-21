<?php

namespace App\Services\Block;

use App\Models\Block;

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
        $block=Blog::where('name',$blockName);
        $blog=Blog::where('name',$blogName);

        if($blog==null || $block==null)
            return 404;

        $notAuthorized=$blog
                    ->users()
                    ->where('user_id',$user->id)
                    ->where('full_priveledges', 1)
                    ->isEmpty();

        if($notAuthorized)
            return 403;

        if($blog->blocks->contains('blocked_blog_id',$block->id))
            return 409;
        
        $blog->blocks()->create([
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
        $unblock=Blog::where('name',$unblockName);
        $blog=Blog::where('name',$blogName);

        if($blog==null || $unblock==null)
            return 404;

        $notAuthorized=$blog
                    ->users()
                    ->where('user_id',$user->id)
                    ->where('full_priveledges', 1)
                    ->isEmpty();

        if($notAuthorized)
            return 403;

        if($blog->blocks->contains('blocked_blog_id',$unblock->id)==false)
            return 409;

        $blog->blocks()->where('blocked_blog_id')->delete();
        
        return 200;
    }

    /**
     * implements the logic of getting the blocks of a blog
     * 
     * @return int
     */
    public function GetBlogBlocks($blogName,$user)
    {
        $blog=Blog::where('name',$blogName);

        if($blog==null)
            return 404;

        $blocks=$blog->blocks;

        return [200,$blocks];
    }

}
