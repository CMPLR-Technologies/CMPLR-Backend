<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\PostTags;
use App\Models\Tag;
use App\Models\TagUser;
use App\Models\User;
use App\Services\User\UserTagsService;
use Tests\TestCase;

class UserTagsTest extends TestCase
{
    
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_un_follow_tag()
    {
        $tagName = Tag::take(1)->first()->value('name') ;
        $userId =User::take(1)->first()->value('id') ;
        TagUser::Create([
            'tag_name' => $tagName,
            'user_id' =>  $userId ,
        ]);
      
        $check = (new UserTagsService)->UserUnFollowTag($tagName , $userId);
        $this->assertTrue($check);
    }

     /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_get_tag_posts()
    {
        $tagName = Tag::take(1)->inRandomOrder()->value('name') ;
        $postId = Post::take(1)->first()->value('id');

        PostTags::Create([
            'tag_name' => $tagName,
            'post_id' =>  $postId ,
        ]);

      
        $check = (new UserTagsService)->GetTagPosts($tagName );
        $this->assertNotNull($check->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_fail_get_tag_posts()
    {
        $tagName = null ;
        $postId =12121;

        
        $check = (new UserTagsService)->GetTagPosts($tagName );
        $this->assertNull($check->first());
    }

   


}
