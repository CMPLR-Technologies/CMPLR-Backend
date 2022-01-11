<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\PostNotes;
use App\Models\Posts;
use App\Models\User;
use App\Services\Posts\PostsService;
use App\Services\User\UserPostService;
use App\Services\User\UserService;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /*
     | this test file is responsible for testing 
     |  profile validations and serivces
     */

    

    protected static $data;


    /**
     *    test miniview profile
     */ 
  
    /**
     * test get data of post using blog id.
     *
     * @return void
     */
    /** @test */
    public function TestMiniViewPostData()
    {
        $blog = Blog::take(1)->first();
        $check = (new PostsService())->MiniViewPostData($blog->id);
        $this->assertNotNull($check);
        self::$data  =  $check;
    }
    
    /** @test */
    public function TestMiniViewPostDataFailure()
    {
        $nonExistBlogId = 9999;
        $check = (new PostsService())->MiniViewPostData($nonExistBlogId);
        $this->assertEmpty($check);
    }

    /**
     * test get data of blog.
     *
     * @return void
     */
    /** @test */
    public function TestMiniViewBlogData()
    {
        $blog = Blog::take(1)->first();
        $check = (new PostsService())->MiniViewBlogData($blog);
        $this->assertNotNull($check);
    }

    /**
     * test get data of blog.
     *
     * @return void
     */
    /** @test */
    public function TestGetViews()
    {
        $check = (new PostsService())->GetViews(self::$data);
        $this->assertNotNull($check);
    }

    /**
     * test profile likes  
     */ 

    /** @test */
    public function TestGetLikes()
    {
        $userId = PostNotes::take(1)->first()->id;
        $check = (new UserService())->GetLikes($userId);
        $this->assertNotNull($check);
    }

     /** @test */
     public function TestGetLikesFailure()
     {
         $notExistuserId = 99999;
         $check = (new UserService())->GetLikes($notExistuserId);
         $this->assertNotNull($check);
     }


}
