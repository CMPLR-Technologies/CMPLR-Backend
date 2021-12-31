<?php

namespace Tests\Unit;

use App\Models\PostNotes;
use App\Models\Posts;
use App\Models\User;
use App\Services\User\UserPostService;
use Tests\TestCase;

class UserPostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_user_like_post()
    {
        $userId = User::take(1)->first()->value('id');
        $postId = Posts::take(1)->first()->value('id');

        $check = (new UserPostService)->UserLikePost($userId  , $postId);
        $this->assertTrue($check);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_fail_user_like_post()
    {
        // undefined Ids for user and post
        $userId = 1000000000;
        $postId = 11516000;

        $check = (new UserPostService)->UserLikePost($userId  , $postId);
        $this->assertFalse($check);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_user_unlike_post()
    {
        $userId =PostNotes::where('type' ,'like')->first()->value('user_id');
        $postId =PostNotes::where('type' ,'like')->first()->value('post_id');
        $check = (new UserPostService)->UserUnlikePost($userId  , $postId);
         $this->assertTrue($check);
    }

     /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_fail_user_unlike_post()
    {
        $userId =1000;
        $postId =100000;
        $check = (new UserPostService)->UserUnlikePost($userId  , $postId);
         $this->assertFalse($check);
    }

     /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_succes_user_is_already_like_post()
    {
        $userId =PostNotes::where('type' ,'like')->first()->value('user_id');
        $postId =PostNotes::where('type' ,'like')->first()->value('post_id');

        $check = (new UserPostService)->IsLikePost($userId  , $postId);
        $this->assertTrue($check);
    }

     /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_is_not_like_post()
    {
        $userId =100200;
        $postId =115151;

        $check = (new UserPostService)->IsLikePost($userId  , $postId);
        $this->assertFalse($check);
    }

    /**
     * 
     */
    public function test_sucess_user_reply_post()
    {
        $userId =User::take(1)->first()->value('id');
        $postId =Posts::take(1)->first()->value('id');
        $replyText = "hello cmplr";
        $check = (new UserPostService)->UserReplyPost($userId  , $postId , $replyText);
        $this->assertTrue($check);
    }

     /**
     * 
     */
    public function test_fail_user_reply_post()
    {
        $userId =100005555;
        $postId =48484848;
        $replyText = "hello cmplr";
        $check = (new UserPostService)->UserReplyPost($userId  , $postId , $replyText);
        $this->assertFalse($check);
    }

   
}
