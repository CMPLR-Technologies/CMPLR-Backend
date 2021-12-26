<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use Illuminate\Http\Request;
use App\Services\User\UserTagsService;


class UserTagsConroller extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | UsertagsConroller
     |--------------------------------------------------------------------------|
     | This Service handles all UserTags  
     |
     */
    protected $userTagsService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(UserTagsService $userTagsService)
    {
        $this->userTagsService = $userTagsService;
    }
    /**
     * @OA\Post(
     *   path="/user/tags/add",
     *   tags={"Users"},
     *   summary="follow new tag",
     *   operationId="follow tag",
     *  @OA\Parameter(
     *      name="tag_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Success",
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
     *)
     **/
    public function FollowTag(Request $request)
    {
        // getting current user
        $user = auth()->user();
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        //getting tag name 
        $tagName = $request->tag_name;
       
        if (!$this->userTagsService->UserFollowTag($tagName, $user->id))
        {
        
            return $this->error_response(Errors::ERROR_MSGS_400 , 'error while follow tag' , 400);

        }
        return $this->success_response('Success' ,200);

    }


    /**
     * @OA\Delete(
     *   path="/user/tags/remove",
     *   tags={"Users"},
     *   summary="unfollow tag",
     *   operationId="unfollow tag",
     *  @OA\Parameter(
     *      name="tag_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Success",
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
     *)
     **/
    public function UnFollowTag(Request $request)
    {
        // getting current user
        $user = auth()->user();
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        //getting tag name 
        $tagName = $request->tag_name;
        if(!$this->userTagsService->UserUnFollowTag($tagName ,$user->id))
        {
            return $this->error_response(Errors::ERROR_MSGS_400 , 'error while unfollow tag' , 400);
        }
       
         return $this->success_response('Success' ,200);
    }
}
