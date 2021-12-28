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
        return PostNotes::where('post_id', $postId)->get();

    }
    /**
     * geting notes count for specific post.
     * 
     * @param integer $postId
     * 
     * @return array 
     */
    public function GetNotesCount($postId)
    {
        $result  =PostNotes::where('post_id', $postId)->select('type', DB::raw('count(*) as total'))->groupBy('type')->get();
        $counts =array('like'=> 0,
                       'reply'=> 0,
                       'reblog'=>0);
        foreach ($result as $count)
        {
            $counts[$count->type] = $count->total ;
        }

        return $counts ;

    }
  
}
