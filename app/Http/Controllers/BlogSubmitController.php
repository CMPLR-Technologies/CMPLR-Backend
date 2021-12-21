<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Helpers\Success;
use App\Http\Requests\Submit\CreateSubmitRequest;
use App\Services\Submit\SubmitService;
use Illuminate\Http\Request;

class BlogSubmitController extends Controller
{
    /**
     * @OA\Post(
     *   path="/blog/{blogName}/submit",
     *   summary="Submit a Post",
     *   description="Used to submit a post to a blog's inbox",
     *   operationId="submitPost",
     *   tags={"Blogs"},
     * 
     *     @OA\Parameter(
     *     name="content",
     *     description="sumbit content",
     *     in="query",
     *     required=true,
     *     @OA\Schema(type="jsonb")
     *   ),
     * 
     *   @OA\Parameter(
     *     name="title",
     *     description="Blog title",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     * 
     *     @OA\Parameter(
     *     name="type",
     *     description="type of the submit 'photo,text,..etc'",
     *     in="query",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     * 
     *     @OA\Parameter(
     *     name="tags",
     *     description="list of tags",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="json")
     *   ),
     *      
     *     @OA\Parameter(
     *     name="mobile",
     *     description="was it sent through mobile",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="boolean")
     *   ),
     * 
     * 	 @OA\Response(
     *     response=404,
     *     description="wrong target blog",
     * 	 ),
     * 	 @OA\Response(
     * 	   response=401,
     * 	   description="Unauthenticated"
     * 	 ),
     * 	 @OA\Response(
     * 	   response=200,
     *     description="Success",
     *   ),
     * )
     */

    public function CreateSubmit(CreateSubmitRequest $request,$blogName)
    {
        //call the service
        $code=(new SubmitService())->CreateSubmit($request->only('content','type','tags','mobile','title'),$blogName);        

        //return the response
        if($code==201)
            return $this->success_response(Success::CREATED,201);
        else if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'wrong target blog',404);

    }


     /**
     * @OA\Delete(
     *   path="/submit/{submitId}",
     *   summary="detete a submit",
     *   description="Used to delete a submit from the inbox",
     *   operationId="DeleteSubmit",
     *   tags={"Posts"},
     * 
     * 	 @OA\Response(
     *     response=404,
     *     description="wrong targets",
     * 	 ),
     * 	 @OA\Response(
     * 	   response=401,
     * 	   description="Unauthenticated"
     * 	 ),
     * 
     * 	 @OA\Response
     *	 (
     *	   response=403,
     *	   description="forbidden"
     *	 ),
     *
     * 	 @OA\Response(
     * 	   response=200,
     *     description="Success",
     *   ),
     * )
     */

    /**
    * delete a submit send by a user to a blog
    * 
    * @return response
    */
    public function DeleteSubmit($submitId)
    {
        //call the service
        $code=(new SubmitService())->DeleteSubmit($submitId,auth()->user());

        //return the response
        if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'wrong targets',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not a member of the blog',403);
        else
            return $this->success_response(Success::DELETED,202);

    }



      /**
     *	@OA\Post
     *	(
     * 		path="/submit/{submitId}",
     * 		summary="edit and post a submit",
     * 		description="used to  a submit send to a blog",
     * 		operationId="PostSubmit",
     * 		tags={"Posts"},
     * 
     *   	@OA\Parameter
     *		(
     *      		name="content",
     *      		description="the content of the answer",
     *      		in="query",
     *      		required=true,
     *      		@OA\Schema
     *			    (
     *           		type="jsonb"
     *      	 	)
     *   	),
     *
     *      @OA\Parameter
     *		(
     *      		name="mobile",
     *      		description="was it send using a mobile",
     *      		in="query",
     *      		required=true,
     *      		@OA\Schema
     *			    (
     *           		type="boolean"
     *      	 	)
     *   	),
     * 
     * 		@OA\Response
     *		(
     *    		response=404,
     *    		description="Not Found",
     * 		),
     *
     *	   	@OA\Response
     *		(
     *		      response=401,
     *		      description="Unauthenticated"
     *	   	),
     *
     *	   	@OA\Response
     *		(
     *		      response=403,
     *		      description="forbidden"
     *	   	),
     *
     *		@OA\Response
     *		(
     *	    	response=200,
     *    		description="posted successfully",
     *     	)
     * )
     */


    /**
     * answer a submit send by a user to a blog
     * 
     * @return response
     */
    public function PostSubmit(CreatePostRequest $request,$submitId)
    {

        //call the service
        $code=(new SubmitService())->DeleteSubmit($submitId,auth()->user());

        //return the response
        if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'wrong targets',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user not a member of the blog',403);
 
        //create an answer (which is just a post)
        

    }



}
