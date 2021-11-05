<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AskController extends Controller
{


        /**
    *	@OA\Post
    *	(
    * 		path="ask/{blog-identifier}",
    * 		summary="Ask A Blog",
    * 		description="used to send a question to a blog",
    * 		operationId="CreateAsk",
    * 		tags={"blogs"},
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
}
