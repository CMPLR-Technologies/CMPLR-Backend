<?php

namespace Tests\Unit;

use App\Models\Block;
use App\Models\Blog;
use App\Services\Block\BlockService;
use Tests\TestCase;

class BlockTest extends TestCase
{

    /*
    |--------------------------------------------------------------------------
    | block Test
    |--------------------------------------------------------------------------|
    | This class tests block services
    |
   */

    /**
     *  
     *  BlockBlog: testing if the request is valid
     * 
     */

    public function test_BlockBlog_Success()
    {
        $blog=Blog::take(1)->first();
        $block=Blog::where('id','!=',$blog->id)->first();
        $user=$blog->users->first();

        $blog->Blocks()->where('blocked_blog_id',$block->id)->delete();

        $code=(new BlockService())->BlockBlog($block->blog_name,$blog->blog_name,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  BlockBlog: testing if the targets are not found
     * 
     */

    public function test_BlockBlog_NotFound()
    {
        $blog=null;
        $block=null;
        $user=null;

        $code=(new BlockService())->BlockBlog($block,$blog,$user);
                                                    
        $this->assertEquals(404,$code);
    }

    /**
     *  
     *  BlockBlog: testing if the blog is already blocked
     * 
     */

    public function test_BlockBlog_Conflict()
    {
        $blocked=Block::take(1)->first();
        $blog=Blog::find($blocked->blog_id);
        $block=Blog::find($blocked->blocked_blog_id);
        $user=$blog->users->first();

        $code=(new BlockService())->BlockBlog($block->blog_name,$blog->blog_name,$user);
                                                    
        $this->assertEquals(409,$code);
    }

    /**
     *  
     *  UnblockBlog: testing if the request is valid
     * 
     */

    public function test_UnblockBlog_Success()
    {
        $blocked=Block::take(1)->first();
        $blog=Blog::find($blocked->blog_id);
        $block=Blog::find($blocked->blocked_blog_id);
        $user=$blog->users->first();

        $code=(new BlockService())->UnblockBlog($block->blog_name,$blog->blog_name,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  UnblockBlog: testing if the targets are not found
     * 
     */

    public function test_UnblockBlog_NotFound()
    {
        $blog=null;
        $block=null;
        $user=null;

        $code=(new BlockService())->UnblockBlog($block,$blog,$user);
                                                    
        $this->assertEquals(404,$code);
    }

    /**
     *  
     *  UnblockBlog: testing if the blog is already unblocked
     * 
     */

    public function test_UnblockBlog_Conflict()
    {
        $blog=Blog::take(1)->first();
        $block=Blog::where('id','!=',$blog->id)->first();
        $user=$blog->users->first();

        $blog->Blocks()->where('blocked_blog_id',$block->id)->delete();

        $code=(new BlockService())->UnblockBlog($block->blog_name,$blog->blog_name,$user);
                                                    
        $this->assertEquals(409,$code);
    }

    /**
     *  
     *  GetBlogBlocks: testing if the request is valid
     * 
     */

    public function test_GetBlogBlocks_Success()
    {
        $blog=Blog::take(1)->first();
        $user=$blog->users->first();

        [$code,$dummy]=(new BlockService())->GetBlogBlocks($blog->blog_name,$user);
                                                    
        $this->assertEquals(200,$code);
    }

    /**
     *  
     *  GetBlogBlocks: testing if the targets are not found
     * 
     */

    public function test_GetBlogBlocks_NotFound()
    {
        $blog=null;
        $block=null;
        $user=null;

        [$code,$dummy]=(new BlockService())->GetBlogBlocks($block,$blog,$user);
                                                    
        $this->assertEquals(404,$code);
    }



}
