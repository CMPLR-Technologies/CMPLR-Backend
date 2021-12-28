<?php

namespace App\Services\Post;

use App\Models\Blog;
use App\Models\PostNotes;
use Illuminate\Support\Facades\DB;

class PostNotesService
{
    /**
     * geting post notes for specific post.
     * 
     * @param integer $postId
     * 
     * @return array $notes
     */
    public function GetPostNotes($postId)
    {
        return  PostNotes::where('post_id', $postId)->get();

    }
  
  
}
