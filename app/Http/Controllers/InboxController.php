<?php

namespace App\Http\Controllers;

use App\Http\Resources\InboxCollection;
use App\Services\Inbox\GetBlogInboxService;
use App\Services\Inbox\GetInboxService;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Inbox Controller
    |--------------------------------------------------------------------------|
    | This controller handles Inbox messages
    |
   */

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
        //get authenticated user
        $user=auth()->user();

        $ret=(new GetInboxService())->GetInbox($user);

        $code=$ret[0];
        $inbox=$ret[1];

        return $this->success_response(new InboxCollection($inbox),$code);
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
        $inbox=$ret[1];

        return $this->success_response(new InboxCollection($inbox),$code);
    }
}
