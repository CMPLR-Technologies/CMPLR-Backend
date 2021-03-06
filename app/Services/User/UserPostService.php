<?php

namespace App\Services\User;

use App\Models\PostNotes;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;

class UserPostService
{
    /*
     |--------------------------------------------------------------------------
     | UserPostService
     |--------------------------------------------------------------------------|
     | This Service handles all UserPost controller needed 
     |
     */
    /**
     * user like post 
     * 
     * @param User user
     * @param string reblogKey
     * @param integer postId 
     *
     * @return bool 
     * @author Yousif Ahmed 
     */
    public function UserLikePost(int $userId, int $postId): bool
    {

        try {
            PostNotes::create([
                'user_id' =>  $userId,
                'post_id' => $postId,
                'type' => 'like',
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

    /**
     * user unlike post 
     * 
     * @param User user
     * @param integer postId 
     *
     * @return bool 
     * @author Yousif Ahmed 
     */
    public function UserUnlikePost(int $userId, int $postId): bool
    {
        $result = false;
        try {
            $result = DB::table('post_notes')->where(['user_id' => $userId, 'post_id' => $postId])->delete();
        } catch (\Throwable $th) {
            return false;
        }
        return $result;
    }
    /**
     * user already like post 
     * 
     * @param User user
     * @param integer postId 
     *
     * @return bool 
     * @author Yousif Ahmed 
     */
    public function IsLikePost(int $userId, int $postId): bool
    {
        return (PostNotes::where(['user_id' => $userId, 'post_id' => $postId])->first()) ? true : false;
    }
    /**
     * user reply post 
     * 
     * @param User $user
     * @param integer $postId 
     * @param $replyText
     * @return bool 
     * @author Yousif Ahmed 
     */
    public function UserReplyPost($userId, $postId, $replyText): bool
    {
        try {
            PostNotes::create([
                'user_id' =>  $userId,
                'post_id' => $postId,
                'type' => 'reply',
                'content' => $replyText
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
    /**
     * getting user blog id of the post 
     * 
     * @param $postId
     *
     * @return $blogId 
     * @author Yousif Ahmed 
     */
    public function GetPostBlogId($postId)
    {
        $blogId = null ;
        try {
            $blogId =Posts::select('blog_id')->where('id', $postId)->first();
        } catch (\Throwable $th) {
            return null;
        }
        return $blogId ;
    }
}
