<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Success;
use App\Http\Requests\Ask\CreateAsk;
use App\Http\Requests\Ask\CreateAskRequest;
use App\Models\Blog;
use App\Models\Post;
use App\Providers\AuthServiceProvider;
use App\Services\Ask\CreateAskService;
use App\Http\Misc\Helpers\Errors;
use App\Http\Requests\Ask\AnswerAskRequest;
use App\Services\Ask\AnswerAskService;
use App\Services\Ask\DeleteAskService;
use App\Services\Inbox\GetBlogInboxService;
use App\Services\Inbox\GetInboxService;
use Error;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AskController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Ask Controller
    |--------------------------------------------------------------------------|
    | This controller handles Asks
    |
   */

    /**
     *	@OA\Post
     *	(
     * 		path="/blog/{blogName}/ask",
     * 		summary="Ask A Blog",
     * 		description="used to send a question to a blog",
     * 		operationId="CreateAsk",
     * 		tags={"Blogs"},
     *
     *   	@OA\Parameter
     *		(
     *      		name="content",
     *      		description="the content of the ask",
     *      		in="query",
     *      		required=true,
     *      		@OA\Schema
     *			    (
     *           		type="html"
     *      	 	)
     *   	),
     *
     * 
     *      @OA\Parameter
     *		(
     *      		name="mobile",
     *      		description="was it send using a mobile",
     *      		in="query",
     *      		required=false,
     *      		@OA\Schema
     *			    (
     *           		type="boolean"
     *      	 	)
     *   	),
     * 
     *      @OA\Parameter
     *		(
     *      		name="is_anonymous",
     *      		description="was it asked anonymously or not",
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
     *		@OA\Response
     *		(
     *	    	response=201,
     *    		description="created successfully",
     *     	)
     * )
     */


    /**
     * creates an Ask send by a user to a blog
     * 
     * @return response
     */

    public function CreateAsk(CreateAskRequest $request,$blogName)
    {   
        //call the service
        $code=(new CreateAskService())->CreateAsk($request->all(),$blogName);        

        //return the response
        if($code==201)
            return $this->success_response(Success::CREATED,201);
        else if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'wrong target blog',404);

    }



    /**
     *	@OA\Post
     *	(
     * 		path="/ask/{askId}",
     * 		summary="answer an ask",
     * 		description="used to answer an aks send to a blog",
     * 		operationId="AnswerAsk",
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
     *           		type="html"
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
     *      		name="mobile",
     *      		description="was it send using a mobile",
     *      		in="query",
     *      		required=false,
     *      		@OA\Schema
     *			    (
     *           		type="boolean"
     *      	 	)
     *   	),
     * 
     *      @OA\Parameter
     *		(
     *      		name="tags",
     *      		description="tags of the answer",
     *      		in="query",
     *      		required=false,
     *      		@OA\Schema
     *			    (
     *           		type="array"
     *      	 	)
     *   	),
     * 
     * 
     *      @OA\Parameter
     *		(
     *      		name="state",
     *      		description="state of the answer publish,private,draft",
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
     *    		description="answered successfully",
     *     	)
     * )
     */


    /**
     * answer an Ask send by a user to a blog
     * 
     * @return response
     */
    public function AnswerAsk(Request $request,$askId)
    {
        $this->validate($request,[
            'content'=>'required',
            'mobile'=>'boolean',
            'source_content'=>'string',
            'tags'=>'array',
            'state'=>['required','string',Rule::in('publish','private','draft')],
        ]);

        $code=(new AnswerAskService())->AnswerAsk($request->all(),$askId,auth()->user());

        //return the response
        if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'wrong targets',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user not a member of the blog',403);
        else
            return $this->success_response('Answered',200);

    }


    /**
     *	@OA\Delete
     *	(
     * 		path="/ask/{askId}",
     * 		summary="delete an Ask",
     * 		description="user can choose not to answer an ask",
     * 		operationId="DeleteAsk",
     * 		tags={"Posts"},
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
     *	    	response=202,
     *    		description="deleted successfully",
     *     	)
     * )
     */

    /**
    * delete an Ask send by a user to a blog
    * 
    * @return response
    */
    public function DeleteAsk($askId)
    {
        //call the service
        $code=(new DeleteAskService())->DeleteAsk($askId,auth()->user());

        //return the response
        if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'wrong targets',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not a member of the blog',403);
        else
            return $this->success_response(Success::DELETED,202);

    }


    /**
     *	@OA\Get
     *	(
     * 		path="/user/inbox",
     * 		summary="the user's inbox",
     * 		description="Retrieve the all asks and  submissions",
     * 		operationId="GetUserInbox",
     * 		tags={"Users"},
     *
     *    	@OA\RequestBody
     *		(
     *      		required=true,
     *      		description="Pass user credentials",
     *    	),
     *
     *	   	@OA\Response
     *		(
     *		      response=401,
     *		      description="Unauthenticated"
     *	   	),
     *
     *		@OA\Response
     *		(
     *	    	response=200,
     *    		description="success",
     *    		@OA\JsonContent
     *			(
     *       			type="object",
     *       			@OA\Property
     *				    (
     *					    property="Meta", type="object",
     *					    @OA\Property(property="Status", type="integer", example=200),
     *					    @OA\Property(property="msg", type="string", example="OK"),
     *        			),
     *
     *       			@OA\Property
     *				    (
     *					    property="response", type="object",
     *             			@OA\Property(property="total_asks", type="Number", example=263),
     *             			@OA\Property(property="total_submissions", type="Number",example=214),     
     *             			@OA\Property
     *					    (
     *						    property="asks",description="asks in user's inbox", type="array",
     *                			@OA\Items
     *						    (
     *			        	        @OA\Property(property="ask_1",description="the first ask",type="object"),
     *			        	        @OA\Property(property="ask_2",description="the second ask",type="object"),
     *			        	        @OA\Property(property="ask_3",description="the third ask",type="object"),
     *			        	    ),
     *               		),
     *
     *             			@OA\Property
     *					    (
     *						    property="submissions",description="submissions in user's inbox", type="array",
     *                			@OA\Items
     *						    (
     *			        	        @OA\Property(property="sub_1",description="the first submission",type="object"),
     *			        	        @OA\Property(property="sub_2",description="the second submission",type="object"),
     *			        	        @OA\Property(property="sub_3",description="the third submission",type="object"),
     *			        	    ),
     *               		),              
     *           		),
     *        		),
     *     	)
     * )
     */
    public function GetInbox()
    {
        $ret=(new GetInboxService())->GetInbox();

        $code=$ret[0];
        $asks=$ret[1];

        return $this->success_response($asks,$code);
    }

    /**
     *	@OA\Get
     *	(
     * 		path="/user/inbox/{blog-identifier}",
     * 		summary="blog's inbox",
     * 		description="Retrieve the all asks and  submissions of a certain blog",
     * 		operationId="GetBlogInbox",
     * 		tags={"Users"},
     *
     *    	@OA\RequestBody
     *		(
     *      		required=true,
     *      		description="Pass user credentials",
     *    	),
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
     *		@OA\Response
     *		(
     *	    	response=200,
     *    		description="success",
     *    		@OA\JsonContent
     *			(
     *       			type="object",
     *       			@OA\Property
     *				    (
     *					    property="Meta", type="object",
     *					    @OA\Property(property="Status", type="integer", example=200),
     *					    @OA\Property(property="msg", type="string", example="OK"),
     *        			),
     *
     *       			@OA\Property
     *				    (
     *					    property="response", type="object",
     *             			@OA\Property(property="total_asks", type="Number", example=263),
     *             			@OA\Property(property="total_submissions", type="Number",example=214),     
     *             			@OA\Property
     *					    (
     *						    property="asks",description="asks in user's inbox", type="array",
     *                			@OA\Items
     *						    (
     *			        	        @OA\Property(property="ask_1",description="the first ask",type="object"),
     *			        	        @OA\Property(property="ask_2",description="the second ask",type="object"),
     *			        	        @OA\Property(property="ask_3",description="the third ask",type="object"),
     *			        	    ),
     *               		),
     *
     *             			@OA\Property
     *					    (
     *						    property="submissions",description="submissions in user's inbox", type="array",
     *                			@OA\Items
     *						    (
     *			        	        @OA\Property(property="sub_1",description="the first submission",type="object"),
     *			        	        @OA\Property(property="sub_2",description="the second submission",type="object"),
     *			        	        @OA\Property(property="sub_3",description="the third submission",type="object"),
     *			        	    ),
     *               		),              
     *           		),
     *        		),
     *     	)
     * )
     */
    public function GetBlogInbox($blogName)
    {

        $ret =(new GetBlogInboxService())->GetBlogInbox($blogName);

        $code=$ret[0];
        $asks=$ret[1];

        return $this->success_response($asks,$code);
    }
}

