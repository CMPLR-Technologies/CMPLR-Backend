<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Blog\BlogService;
use Tests\TestCase;

class BlogTest extends TestCase
{
    // Testing Explore blogs
    /** @test */
    public function TestGetRandomBlogs()
    {
        $userId = User::take(1)->first()->id;
        $check = (new BlogService())->GetRandomBlogs($userId);
        $this->assertNotEmpty($check);
    }
}