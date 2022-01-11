<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Posts;
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
        // $tagName = Tag::take(1)->first()->value('name');
        // $userId =User::take(1)->first()->value('id') ;
        // TagUser::Create([
        //     'tag_name' => $tagName,
        //     'user_id' =>  $userId ,
        // ]);

        $userTag = TagUser::take(1)->first();
        $check = (new UserTagsService)->UserUnFollowTag($userTag->tag_name, $userTag->user_id);
        $this->assertTrue($check);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_get_tag_posts()
    {
        $tagName = Tag::take(1)->inRandomOrder()->value('name');
        $postId = Post::take(1)->first()->value('id');

        PostTags::Create([
            'tag_name' => $tagName,
            'post_id' =>  $postId,
        ]);


        $check = (new UserTagsService)->GetTagPosts($tagName);
        $this->assertNotNull($check->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_fail_get_tag_posts()
    {
        $tagName = null;
        $postId = 12121;


        $check = (new UserTagsService)->GetTagPosts($tagName);
        $this->assertNull($check->first());
    }

    // Testing Explore tags
    /** @test */
    public function TestGetRandomTagsDataWithoutUserId()
    {
        $check = (new UserTagsService())->GetRandomTagsData();
        $this->assertNotEmpty($check);
    }

    /** @test */
    public function TestGetRandomTagsDataWithUserId()
    {
        $userId = User::take(1)->first()->id;
        $check = (new UserTagsService())->GetRandomTagsData($userId);
        $this->assertNotEmpty($check);
    }

    // Testing getting followed tags
    /** @test */
    public function TestGetFollowedTags()
    {
        $userId = User::take(1)->first()->id;
        $check = (new UserTagsService())->GetFollowedTags($userId);
        $this->assertNotNull($check);
    }

    /** @test */
    public function TestGetFollowedTagsFailure()
    {
        $userId = 999;
        $check = (new UserTagsService())->GetFollowedTags($userId);
        $this->assertNotNull($check);
    }

    // Testing getting the tag's recent post count
    /** @test */
    public function TestGetTagRecentPostsCount()
    {
        $tag = Tag::factory()->create(['name' => 'Happy New Year']);
        $posts = Posts::factory()->count(10)->create([
            'tags' => [$tag->name],
            'type' => 'post'
        ]);

        $check = (new UserTagsService())->GetTagRecentPostsCount($posts);
        $this->assertEquals($check, 10);
    }
}