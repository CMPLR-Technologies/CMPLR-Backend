<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\BlogChatCollection;
use App\Http\Resources\LatestMessagesCollection;
use App\Http\Resources\LatestMessagesResource;
use App\Services\Blog\BlogChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogChatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BlogChat Controller
    |--------------------------------------------------------------------------|
    | This controller handles all conversation  
    |
   */
    protected $blogChatService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(BlogChatService $blogChatService)
    {
        $this->blogChatService = $blogChatService;
    }

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

    public function GetMessages($blogId)
    {
        $userid = Auth::user()->id;

        // cehck for valid blogfrom id
        if (!$this->blogChatService->IsValidBlogId($blogId, $userid)) {
            return $this->error_response('Unauthenticated', 'Invalid blog id', 401);
        }
        // getting latest messages 
        $messages = $this->blogChatService->GetLatestMessages($blogId);
        if ($messages->isEmpty())
        {
            return response()->json($messages, 200);
        }

        return response()->json(new LatestMessagesCollection($messages), 200);
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
    public function Conversation($blogIdFrom, $blogIdTo)
    {
        //getting all conversation messages 
        $messages = $this->blogChatService->GetConversationMessages($blogIdFrom, $blogIdTo);
        if (!$messages->isEmpty()) 
        {
            $this->blogChatService->MarkAsRead($messages);
            $response = new BlogChatCollection($messages);
        }else {
            $response['messages']= null ;
        }

        return response()->json($response, 200);
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
    public function SendMessage(Request $request, $blogIdFrom, $blogIdTo)
    {
        $userId = Auth::user()->id;

        // cehck for valid blogfrom id
        if (!$this->blogChatService->IsValidBlogId($blogIdFrom, $userId)) {
            return $this->error_response('Unauthenticated', 'Invalid blog id', 401);
        }
        //creating messages with content 
        $message =$this->blogChatService->CreateMessage($request->Content, $blogIdFrom, $blogIdTo);

        broadcast(new MessageSent($blogIdFrom , $blogIdTo , $message));

        return $this->success_response('Success', 200);
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
    public function DeleteMessgaes($blogIdFrom, $blogIdTo)
    {
        $userId = Auth::user()->id;

        // cehck for valid blogfrom id
        if (!$this->blogChatService->IsValidBlogId($blogIdFrom, $userId)) {
            return $this->error_response('Unauthenticated', 'Invalid blog id', 401);
        }
        $this->blogChatService->DeleteMessages($blogIdFrom, $blogIdTo);

        return $this->success_response('Success', 200);
    }
}
