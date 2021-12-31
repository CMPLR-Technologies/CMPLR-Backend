<?php

namespace Tests\Unit;

use App\Models\PostNotes;
use App\Services\Post\PostNotesService;
use Tests\TestCase;

class PostNotesTest extends TestCase
{
    /**
     * testing successfully getting notes for specific post
     *
     * @return void
     */
    public function test_sucess_get_post_notes()
    {
        $postId = PostNotes::take(1)->first()->value('post_id');
        $check = (new PostNotesService)->GetPostNotes($postId);
        $this->assertNotNull($check->first());
    }

     /**
     *  testing fail to get notes for undefined post
     *
     * @return void
     */
    public function test_fail_get_post_notes()
    {
        $postId =100000000;
        $check = (new PostNotesService)->GetPostNotes($postId);
        $this->assertNull($check->first());
    }
}
