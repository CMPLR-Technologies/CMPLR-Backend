<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogChatController extends Controller
{
    

    /**
     * @OA\Get(
     * path="/messaging",
     * summary="getting all messages",
     * description="This method can be used to get all messages of authorized user",
     * operationId="messaging",
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
     * )
     * )
     */
    public function messaging()
    {
        //
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
     * )
     * )
     */
    public function conversation()
    {
        //
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
     * )
     * )
     */
    public function sendMessage()
    {
        //
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
     * )
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
