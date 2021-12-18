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
        return PostNotes::where('post_id', $postId)->with('user')->get();

    }
    /**
     * geting notes count for specific post.
     * 
     * @param integer $postId
     * 
     * @return array $notes
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

    /**
     * Get User data needed
     *
     * @param PostNotes $notes
     * 
     * @return  $blogs_id
     */
    public function GetBlogsId($notes)
    {
        $blogsId = array();
        foreach ($notes as $note) {
            $blogsId[] = $note->user->primary_blog_id;
        };
        return $blogsId;
    }

    /**
     * Get blogs data needed 
     *
     * @param array $blogsId
     * 
     * @return array
     */
    public function GetBlogsData($blogsId)
    {
        return Blog::whereIn('id', $blogsId)->with(['settings' => function($query){
            $query->select('blog_id','avatar' ,'avatar_shape');
        }])->get();;
    }

    public function HashBlogData ($blogsData)
    {
        $blogsHashData=[];
        foreach ($blogsData as $data)
        {
            $blogsHashData[$data->id]= $data ;
        }
        return $blogsHashData;
    }
    /**
     * Get Notes result 
     *
     * @param array $blogs_id
     * 
     * @return arrayofjson
     */
    public function GetNotesResult($notes , $blogsHashData ,$counts)
    {
        $result = [] ;
        for ($i=0; $i<count($notes); $i++) 
        {
            $result[] =[
                'post_id'=>$notes[$i]->post_id,
                'type' => $notes[$i]->type,
                'content'=> $notes[$i]->content,
                'timestamp'=>$notes[$i]->created_at,
                'blog_name'=>$blogsHashData[$notes[$i]->user_id]->blog_name,
                'blog_url'=>$blogsHashData[$notes[$i]->user_id]->url,
                'avatar'=>$blogsHashData[$notes[$i]->user_id]->settings->avatar ,
                'avatar_shape'=>$blogsHashData[$notes[$i]->user_id]->settings->avatar_shape,

            ];
        }
       
        $result[] =[
            'total_likes'=> $counts['like'],
            'total_reblogs'=> $counts['reblog'],
            'total_replys' => $counts['reply']
        ];
        return ($result) ;
    }
}
