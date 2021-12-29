<?php

namespace App\Services\Blog;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class BlogChatService
{
     /*
    |--------------------------------------------------------------------------
    | BlogChat Service 
    |--------------------------------------------------------------------------|
    | This service handles all BlogChat Controller needed  
    |
   */
    /**
     * Checking for a valid blog id
     * 
     * @param $blogid 
     * @param $userid
     * 
     * @return boolean
     */
    public function IsValidBlogId($blogId, $userId)
    {
        $user_blogs = DB::table('blog_users')->where([['user_id', '=', $userId], ['blog_id', '=', $blogId]])->get();
        return count($user_blogs) > 0;
    }
    /**
     * Getting blogs data for chat parteners as latest conversation
     *
     * @param $messages
     * @param $blogId
     *
     * @return $blogData
     */

    public function GetBlogDataforChatParteners($messages, $blogId)
    {
        $fromBlogIds = ($messages->where('from_blog_id', '!=', $blogId)->pluck('from_blog_id'));
        $toBlogsIds = ($messages->where('to_blog_id', '!=', $blogId)->pluck('to_blog_id'));
        $blogsData = Blog::whereIn('id', $toBlogsIds)->orwhereIn('id', $fromBlogIds)->with(['settings' => function ($query) {
            $query->select('blog_id', 'avatar', 'avatar_shape');
        }])->get();

        return $blogsData;
    }

    /**
     * Getting recent messages to blog
     * @param $blogId
     * @param Chat $messages
     */
    public function GetLatestMessages($blogId)
    {
        $query = '(
            SELECT
            LEAST(from_blog_id, to_blog_id) AS sender_id,
            GREATEST(from_blog_id, to_blog_id) AS receiver_id,
            MAX(id) AS max_id
            FROM chats
            GROUP BY
            LEAST(from_blog_id, to_blog_id),
            GREATEST(from_blog_id, to_blog_id)  ) AS t2';


        $messages = Chat::from('chats AS t1')
            ->select('t1.*')
            ->join(DB::raw($query), fn ($join) => $join
                ->on(DB::raw('LEAST(t1.from_blog_id, t1.to_blog_id)'), '=', 't2.sender_id')
                ->on(DB::raw('GREATEST(t1.from_blog_id, t1.to_blog_id)'), '=', 't2.receiver_id')
                ->on('t1.id', '=', 't2.max_id'))
            ->where('t1.from_blog_id', $blogId)
            ->orWhere('t1.to_blog_id', $blogId)->latest('created_at', 'DESC')->get();

        return $messages;
    }

    /**
     * Getting conversation with defined blog
     * 
     * @param $blogIdFrom
     * @param $blogIdTo
     * 
     * @return Chat $messages
     */
    public function GetConversationMessages($blogIdFrom, $blogIdTo)
    {
        try {
            $conversation = Chat::where([['from_blog_id', '=', $blogIdFrom], ['to_blog_id', '=', $blogIdTo]])->orwhere([['from_blog_id', '=', $blogIdTo], ['to_blog_id', '=',  $blogIdFrom]])->orderBy('created_at', 'DESC')->paginate(Config::Message_PAGINATION_LIMIT);
            return $conversation;
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Marking messages as read 
     * 
     * @param $messages 
     * 
     * @return boolean
     */
    public function MarkAsRead($messages)
    {
        $un_readed_messages =  $messages->where('is_read', false);
        if ($un_readed_messages) {
            foreach ($un_readed_messages as $message) {
                $message->is_read = true;
                $message->save();
            }
        }
        return true ;
    }
    /**
     * Creating message 
     * 
     * @param $content
     * @param $blogIdFrom
     * @param $blogIdTo
     * 
     * @return boolean 
     */

    public function CreateMessage($content, $blogIdFrom, $blogIdTo)
    {
        try {
            return Chat::create([
                'from_blog_id' => $blogIdFrom,
                'to_blog_id' => $blogIdTo,
                'content' => $content
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
    /**
     * Deleting conversation messages 
     * 
     * @param $blogIdFrom 
     * @param $blogIdTo
     * 
     * @return boolean
     */

    public function DeleteMessages($blogIdFrom, $blogIdTo)
    {
        try {
            Chat::where([
                ['from_blog_id', '=', $blogIdFrom],
                ['to_blog_id', '=', $blogIdTo]
            ])
                ->orwhere([['from_blog_id', '=', $blogIdTo], ['to_blog_id', '=',  $blogIdFrom]])->delete();
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}
