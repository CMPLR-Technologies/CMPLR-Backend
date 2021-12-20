<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Models\Blog;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogChatController extends Controller
{
    

    /**
     * @OA\Get(
     * path="/blog/messaging",
     * summary="getting all messages",
     * description="This method can be used to get all messages of authorized user",
     * operationId="Messaging",
     * tags={"Chats"},
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       ),
     *       @OA\Property(property="response", type="object",
     *         @OA\Property(property="blog-id_from", type="integer", example=123154564),
     *         @OA\Property(property="blog-name_from", type="Sring", example="summer-abdlhamid"),
     *         @OA\Property(property="blog-id_to", type="integer", example=634344),
     *         @OA\Property(property="blog-name_to", type="Sring", example="yousif-lasheen"),
     *         @OA\Property(property="content", type="Sring", example="hello"),
     *       )
     *    )
     * ),
     * security ={{"bearer":{}}}
     * )
     */
    public function GetMessages()
    {
        $blogId = Auth::User()->id ;
        
        $messages = Chat::where(function ($query) use ($blogId) {
            $query->where('to_blog_id', '=', $blogId)->orwhere('from_blog_id' , '=' ,$blogId );
        })->latest('created_at' ,'ASC')->get();
        //paginate(Config::Message_PAGINATION_LIMIT);
        
        return response()->json([$messages],200);
    }
     /**
     * @OA\Get(
     * path="/messaging/conversation/{blog-id-from}/{blog-id-to}",
     * summary="getting all messages from some blog",
     * description="This method can be used to get all messages from some blog",
     * operationId="conversation",
     * tags={"Chats"},
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Successfully getting all messages",
     *    @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       ),
     *    )
     * ),
     * security ={{"bearer":{}}}
     * )
     */
    public function Conversation($blogIdFrom ,$blogIdTo )
    {
        
        $messages = Chat::where([['from_blog_id' ,'=', $blogIdFrom ],['to_blog_id','=' ,$blogIdTo]])->
        orwhere([['from_blog_id' ,'=',$blogIdTo],['to_blog_id','=',  $blogIdFrom ]])->orderBy('created_at')->get();
        
      
        $un_readed_messages =  $messages->where('is_read', false);
        foreach( $un_readed_messages as $message)
        {
            $message->is_read = true ;
            $message->save();
        }
        
        return response()->json([$messages],200);
    }
    /**
     * @OA\Post(
     * path="/messaging/conversation/{blog-id-from}/{blog-id-to}",
     * summary="send message to blog",
     * description="This method can be used to send message to blog",
     * operationId="sendMessage",
     * tags={"Chats"},
     * @OA\Parameter(
     *         name="Content",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"Content"},
     *       @OA\Property(property="Content", type="string", format="string", example="hello"),
     *    ),
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Successfully sending messages",
     *    @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       ),
     *    )
     * ),
     * security ={{"bearer":{}}}
     * )
     */
    public function SendMessage(Request $request ,$blogIdFrom ,$blogIdTo)
    {
        $user_id =Auth::user()->id;

        // cehck for valid blogfrom id

        $user_blogs =DB::table('blog_users')->where([['user_id','=' ,$user_id] ,['blog_id','=' ,$blogIdFrom ] ] )->get();
        if (!count($user_blogs))
        {
            return $this->error_response('Unauthenticated' ,'Invalid blog id', 401);
        }

        Chat::create([
            'from_blog_id' => $blogIdFrom ,
            'to_blog_id' =>$blogIdTo ,
            'content' => $request->Content
        ]);

        return $this->success_response('Success' ,200);
    }
    /**
     * @OA\Delete(
     * path="/messaging/conversation/{blog-id-from}/{blog-id-to}",
     * summary="delete all messages with blog",
     * description="This method can be used to send message to blog",
     * operationId="destroy",
     * tags={"Chats"},
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Successfully deleting messages",
     *    @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       ),
     *    )
     * ),
     * security ={{"bearer":{}}}
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteMessgaes(Request $request ,$blogIdFrom ,$blogIdTo)
    {
        $user_id =Auth::user()->id;

        // cehck for valid blogfrom id

        $user_blogs =DB::table('blog_users')->where([['user_id','=' ,$user_id] ,['blog_id','=' ,$blogIdFrom ] ] )->get();
        if (!count($user_blogs))
        {
            return $this->error_response('Unauthenticated' ,'Invalid blog id', 401);
        }

        Chat::where([['from_blog_id' ,'=', $blogIdFrom ],['to_blog_id','=' ,$blogIdTo]])->
        orwhere([['from_blog_id' ,'=',$blogIdTo],['to_blog_id','=',  $blogIdFrom ]])->delete();
        
        return $this->success_response('Success' ,200);

        
    }
}


