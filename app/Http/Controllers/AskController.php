<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AskController extends Controller
{


        /**
    *	@OA\Post
    *	(
    * 		path="blog/{blog-identifier}/ask",
    * 		summary="Ask A Blog",
    * 		description="used to send a question to a blog",
    * 		operationId="CreateAsk",
    * 		tags={"Blogs"},
    *
    *   	@OA\Parameter
    *		(
    *      		name="anonymously",
    *      		description="whether to ask the question anonymously or to use the user info",
    *      		in="path",
    *      		required=false,
    *      		@OA\Schema
    *			(
    *           		type="Boolean"
    *      		)
    *   	),
    *
    *    	@OA\Parameter
    *		(
    *      		name="question",
    *      		description="the content of the question",
    *      		in="query",
    *      		required=true,
    *      		@OA\Schema
    *			(
    *           		type="String"
    *      		)
    *   	),
    *    
    *    	@OA\RequestBody
    *		(
    *      		required=true,
    *      		@OA\JsonContent
    *			(
    *      		    description="Pass user credentials",
    *	    		required={"question"},
    *      			@OA\Property(property="anonymously", type="Boolean", format="Boolean", example="true"),
    *      			@OA\Property(property="question", type="String", format="text", example="how are you?"),
    *      		),
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
    *     	)
    * )
    */
    public function CreateAsk()
    {

    }

    /**
    *	@OA\Get
    *	(
    * 		path="user/inbox",
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
    public function GetInbox()
    {

    }

    /**
    *	@OA\Get
    *	(
    * 		path="user/inbox/{blog-identifier}",
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
    public function GetBlogInbox()
    {

    }


}
