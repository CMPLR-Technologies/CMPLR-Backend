<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserpostConroller extends Controller
{
    /**
     * @OA\POST(
     * path="/user/like",
     * summary="Like a Post",
     * description="enables the user to like a post through the post id",
     * operationId="UserLike",
     * tags={"Users"},
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="The ID of the post to like",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="reblog_key",
     *      description="The reblog key for the post id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *    
     *    @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *      required={"id","reblog_key"},
     *      @OA\Property(property="id", type="integer", format="integer", example=1),
     *      @OA\Property(property="reblog_key", type="string", format="text", example="hello123"),
     *      ),
     *    ),
     *
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="success",
     *     ),
     * security ={{"bearer":{}}}
     * )
     */
    public function like()
    {
        //
    }

    /**
     * @OA\POST(
     * path="/user/unlike",
     * summary="Unlike a Post",
     * description="enables the user to unlike a post through the post id",
     * operationId="UserUnlike",
     * tags={"Users"},
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="The ID of the post to unlike",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="reblog_key",
     *      description="The reblog key for the post id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *    
     *    @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *      required={"id","reblog_key"},
     *      @OA\Property(property="id", type="integer", format="integer", example=1),
     *      @OA\Property(property="reblog_key", type="string", format="text", example="hello123"),
     *      ),
     *    ),
     *
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="success",
     *     ),
     * security ={{"bearer":{}}}
     * )
     */
    public function unlike()
    {
        //
    }
    /**
     * @OA\Post(
     *   path="/user/post/reply",
     *   tags={"Users"},
     *   summary="add new reply to Specific Post",
     *   operationId="add reply",
     *  @OA\Parameter(
     *      name="post_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="reblog_key",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="reply_text",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="text"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="tumblelog",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *      description="the name of blog containing post to get if he is the original poster",
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not Found"
     *   ),
     *   @OA\Response(
     *          response=201,
     *          description="created Successfully",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="ok"),
     *           ),
     *       ),
     *         
     *          
     *       ),
     * security ={{"bearer":{}}}
     *)
     **/
    public function UserReply()
    {
    }
}