<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Models\PostNotes;
use App\Services\User\UserPostService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserPostConroller extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Userpost Controller
    |--------------------------------------------------------------------------|
    | This controller handles interactions of the user with posts  
    |
   */
    protected $userPostService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(UserPostService $userPostService)
    {
        $this->userPostService = $userPostService;
    }
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
     *  
     *    
     *    @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *      required={"id"},
     *      @OA\Property(property="id", type="integer", format="integer", example=1),
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
    public function Like(Request $request)
    {
        //getting data 
        $postId = $request->id;
        $userId = auth()->user()->id;

        if (!$userId)
        {
            return $this->error_response(Errors::ERROR_MSGS_401,'Unauthenticated',401);

        }
        if (!$postId)
        {
            return $this->error_response(Errors::ERROR_MSGS_404,'Post Id Is required',404);
        }

        if (!$this->userPostService->UserLikePost($userId , $postId))
        {
            return $this->error_response(Errors::ERROR_MSGS_404,'Note Not Found',404);

        }

        return response()->json( ['message'=>'Success'], 200);

       
    }

    /**
     * @OA\Delete(
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
     *    @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *      required={"id"},
     *      @OA\Property(property="id", type="integer", format="integer", example=1),
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
    public function UnLike(Request $request)
    {
        $postId = $request->input('id');
        $userId = auth()->user()->id;
        if (!$userId)
        {
            return $this->error_response(Errors::ERROR_MSGS_401,'Unauthenticated',401);

        }
        if (!$postId)
        {
            return $this->error_response(Errors::ERROR_MSGS_404,'Post Id Is required',404);
        }
        if (!$this->userPostService->UserUnlikePost($userId, $postId)){
            return $this->error_response(Errors::ERROR_MSGS_404,'note Not Found',404);
        }
        return response()->json(['message' => 'success'], 200);
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
