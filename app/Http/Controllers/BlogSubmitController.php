<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Helpers\Success;
use App\Http\Requests\Submit\CreateSubmitRequest;
use App\Services\Submit\SubmitService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
     *     @OA\Schema(type="html")
     *   ),
     * 
     *     @OA\Parameter(
     *     name="type",
     *     description="type of the submit ('text','photo','link','quote','video')",
     *     in="query",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     * 
     *     @OA\Parameter(
     *     name="submissionTag",
     *     description="add 'submission' tag or not",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="boolean")
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

    /**
     * create a submit send by a user to a blog
     * @param CreateSubmitRequest $request
     * @param int $submitId
     * @return response
     */
    public function CreateSubmit(CreateSubmitRequest $request, $blogName)
    {
        //call the service
        $code = (new SubmitService())->CreateSubmit($request->all(), $blogName, auth()->user());

        //return the response
        if ($code == 201)
            return $this->success_response(Success::CREATED, 201);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404, 'wrong target blog', 404);
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
     * @param int $submitId
     * @return response
     */

    public function DeleteSubmit($submitId)
    {
        //call the service
        $code = (new SubmitService())->DeleteSubmit($submitId, auth()->user());

        //return the response
        if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404, 'wrong targets', 404);
        else if ($code == 403)
            return $this->error_response(Errors::ERROR_MSGS_403, 'user is not a member of the blog', 403);
        else
            return $this->success_response(Success::DELETED, 202);
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
     *      		description="the content of the edited submit",
     *      		in="query",
     *      		required=true,
     *      		@OA\Schema
     *			    (
     *           		type="html"
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
     *      @OA\Parameter
     *		(
     *      		name="source_content",
     *      		description="reference link",
     *      		in="query",
     *      		required=false,
     *      		@OA\Schema
     *			    (
     *           		type="string"
     *      	 	)
     *   	),
     * 
     *      @OA\Parameter
     *		(
     *      		name="tags",
     *      		description="tags of the submit",
     *      		in="query",
     *      		required=false,
     *      		@OA\Schema
     *			    (
     *           		type="array",
     *                  @OA\Items ()
     *      	 	)
     *   	),
     * 
     * 
     *      @OA\Parameter
     *		(
     *      		name="state",
     *      		description="state of the submit publish,private,draft",
     *      		in="query",
     *      		required=true,
     *      		@OA\Schema
     *			    (
     *           		type="string"
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
     * approve a submit send by a user to a blog
     * @param Request $request
     * @param int $submitId
     * @return response
     */
    public function PostSubmit(Request $request, $submitId)
    {

        $this->validate($request, [
            'content' => 'required',
            'mobile' => 'boolean',
            'source_content' => 'string',
            'tags' => 'array',
            'state' => ['required', 'string', Rule::in('publish', 'private', 'draft')],
        ]);

        $code = (new SubmitService())->PostSubmit($request->all(), $submitId, auth()->user());

        //return the response
        if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404, 'wrong targets', 404);
        else if ($code == 403)
            return $this->error_response(Errors::ERROR_MSGS_403, 'user not a member of the blog', 403);
        else
            return $this->success_response('Posted', 200);
    }
}