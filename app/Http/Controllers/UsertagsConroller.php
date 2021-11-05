<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsertagsConroller extends Controller
{
      
    /*
    3b hameeed
    */

    /**
     * @OA\Post(
     ** path="/user/tags/add",
     *   tags={"tags"},
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
    public function FollowTag(){

    }


    /**
     * @OA\Delete(
     ** path="/user/tags/remove",
     *   tags={"tags"},
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
    public function UnFollowTag(){

    }

}
