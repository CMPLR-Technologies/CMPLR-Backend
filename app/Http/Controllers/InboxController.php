<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Http\Resources\InboxCollection;
use App\Services\Inbox\DeleteInboxService;
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
     *       		type="object",
     *       		@OA\Property
     *				(
     *					    property="Meta", type="object",
     *					    @OA\Property(property="Status_code", type="integer", example=200),
     *					    @OA\Property(property="msg", type="string", example="OK"),
     *        		),
     *
     *       		@OA\Property
     *				(
     *					property="response", type="object",
     *             		@OA\Property
     *					(
     *						property="messages", type="array",
     *                		@OA\Items
     *						(
     *			        	    @OA\Property(property="message1",description="the first ask",type="object"),
     *			        	    @OA\Property(property="message2",description="the second ask",type="object"),
     *			        	    @OA\Property(property="message3",description="the third ask",type="object"),
     *			        	),
     *             	    ),
     *			        @OA\Property(property="next_url",description="next page in pagination",type="url"),
     *			        @OA\Property(property="total",description="total number of messages",type="integer"),
     *			        @OA\Property(property="current_page",description="current page number",type="integer"),
     *			        @OA\Property(property="messages_per_page",description="number of messages per page",type="integer"),
     *           	),
     *        	),
     *      )
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
     *       		type="object",
     *       		@OA\Property
     *				(
     *					    property="Meta", type="object",
     *					    @OA\Property(property="Status_code", type="integer", example=200),
     *					    @OA\Property(property="msg", type="string", example="OK"),
     *        		),
     *
     *       		@OA\Property
     *				(
     *					property="response", type="object",
     *             		@OA\Property
     *					(
     *						property="messages", type="array",
     *                		@OA\Items
     *						(
     *			        	    @OA\Property(property="message1",description="the first ask",type="object"),
     *			        	    @OA\Property(property="message2",description="the second ask",type="object"),
     *			        	    @OA\Property(property="message3",description="the third ask",type="object"),
     *			        	),
     *             	    ),
     *			        @OA\Property(property="next_url",description="next page in pagination",type="url"),
     *			        @OA\Property(property="total",description="total number of messages",type="integer"),
     *			        @OA\Property(property="current_page",description="current page number",type="integer"),
     *			        @OA\Property(property="messages_per_page",description="number of messages per page",type="integer"),
     *           	),
     *        	),
     *      )
     * )
     */
    public function GetBlogInbox($blogName)
    {

        $ret =(new GetBlogInboxService())->GetBlogInbox($blogName,auth()->user());

        $code=$ret[0];
        $inbox=$ret[1];

        if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user not a member of the blog',403);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else
            return $this->success_response(new InboxCollection($inbox),$code);
    }

    /**
     *	@OA\Delete
     *	(
     * 		path="/user/inbox",
     * 		summary="delelte user's inbox",
     * 		description="delete all messages inside the inbox",
     * 		operationId="DeleteInbox",
     * 		tags={"Users"},
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
    public function DeleteInbox()
    {
        $code=(new DeleteInboxService())->DeleteInbox(auth()->user());
    
        return $this->success_response('all messages are delete',$code);
    }

    public function DeleteBlogInbox($blogName)
    {
        $code=(new DeleteInboxService())->DeleteBlogInbox($blogName,auth()->user());
        
        if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user not a member of the blog',403);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else
            return $this->success_response('all blog messages are delete',$code);
    }

}
