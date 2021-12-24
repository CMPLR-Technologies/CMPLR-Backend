<?php

namespace App\Services\Blog;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class BlogChatService
{

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
     * Getting defined result for messages and blogs data
     * only for reponse structure
     *
     * @param $blogData 
     * @param $messages
     * @param $blogId 
     *
     * @return $collection
     */

    public function GetLatestMessagesResult($blogsData, $messages, $blogId)
    {
        $blogsHashData = [];
        foreach ($blogsData as $data) {
            $blogsHashData[$data->id] = $data;
        }

        for ($i = 0; $i < count($messages); $i++) {
            if ($messages[$i]->from_blog_id != $blogId)
                $id = $messages[$i]->from_blog_id;
            else
                $id =  $messages[$i]->to_blog_id;
            $collection[] = [
                'from_blog_id' => $messages[$i]->from_blog_id,
                'to_blog_id' => $messages[$i]->to_blog_id,
                'content' => $messages[$i]->content,
                'is_read' => $messages[$i]->is_read,
                'blog_data' => [
                    'blog_id' => $id,
                    'blog_name' => $blogsHashData[$id]->blog_name,
                    'blog_url' => $blogsHashData[$id]->url,
                    'avatar'   => $blogsHashData[$id]->settings->avatar,
                    'avatar_shape' => $blogsHashData[$id]->settings->avatar_shape,

                ]

            ];
        }
        return $collection;
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
        try{
           $conversation = Chat::where([['from_blog_id', '=', $blogIdFrom], ['to_blog_id', '=', $blogIdTo]])->orwhere([['from_blog_id', '=', $blogIdTo], ['to_blog_id', '=',  $blogIdFrom]])->orderBy('created_at' ,'DESC')->paginate(Config::Message_PAGINATION_LIMIT);
           return $conversation ;
            
        } catch (\Throwable $th) {
            return null;
        }

    }

    /**
     * Getting blog data for defined blog id 
     * 
     * @param $blogId 
     * 
     * @return $blogData
     */
    public function GetBlogData($blogId)
    {
        return  Blog::where('id', $blogId)->with('settings')->get();
    }

    /**
     * Marking messages as read 
     * 
     * @param $messages 
     * 
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
    }

    public function ConversationDataResult($recieverBlogData, $messages)
    {
        $blogData[] = [
            'blog_name' => $recieverBlogData[0]->blog_name,
            'url' => $recieverBlogData[0]->url,
            'title' => $recieverBlogData[0]->title,
            'avatar' => $recieverBlogData[0]->avatar,
            'avatar_shape' => $recieverBlogData[0]->avatar_shape
        ];

        $result[] = [

            'blog_data' => $blogData[0],
            'messages' => $messages
        ];

        return $result;
    }

    public function CreateMessage($content, $blogIdFrom, $blogIdTo)
    {

        Chat::create([
            'from_blog_id' => $blogIdFrom,
            'to_blog_id' => $blogIdTo,
            'content' => $content
        ]);
    }

    public function DeleteMessages($blogIdFrom , $blogIdTo)
    {
        Chat::where([['from_blog_id', '=', $blogIdFrom], ['to_blog_id', '=', $blogIdTo]])->orwhere([['from_blog_id', '=', $blogIdTo], ['to_blog_id', '=',  $blogIdFrom]])->delete();

    }
}