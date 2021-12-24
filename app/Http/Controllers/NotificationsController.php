<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Services\Notifications\NotificationsService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    /**
     * @OA\Get(
     *   path="/notifications",
     *   summary="Retrieve Blog's Activity Feed",
     *   description="Retrieve the activity items for a specific blog.",
     *   operationId="notifications",
     *   tags={"Blogs"},
     *   @OA\Parameter(
     *     name="blog-identifier",
     *     in="path",
     *     description="Any blog identifier",
     *     required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *         name="type[]",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *         type="array",
     *              @OA\Items(type="string")
     *          )
     *      ),
     *  @OA\RequestBody(
     *    required=true,
     *    description="Api Example : api.tumblr.com/v1/blog/{blog-identifier}/notifications <br/>
     *    Available types include:\n <br/>
     *      all : get all notifications  <br/>
     *      like:	A like on your post <br/>
     *      reply:	A reply on your post <br/>
     *      follow:	A new follower <br/>
     *      mention_in_reply:	A mention of your blog in a reply <br/>
     *      mention_in_post:	A mention of your blog in a post <br/>
     *      reblog_naked:	A reblog of your post, without commentary <br/>
     *      reblog_with_content:	A reblog of your post, with commentary <br/>
     *      ask:	A new ask received <br/>
     *      answered_ask:	An answered ask that you had sent <br/>
     *      new_group_blog_member:	A new member of your group blog <br/>
     *      post_flagged:	A post of yours being flagged <br/>
     *      conversational_note	A conversational note (reply, reblog with comment) on a post you're watching",
     *    @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="type", type="string", format="text", example="all"),
     *    ),
     * ),
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
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="total_users", type="integer", example=1235),           
     *             @OA\Property(property="notifications", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="type",
     *                         type="string",
     *                         example="like"
     *                      ),
     *                      @OA\Property(
     *                         property="timestamp",
     *                         type="integer",
     *                         example=1636069200
     *                      ),
     *                      @OA\Property(
     *                         property="targetBlogName",
     *                         type="string",
     *                         example="ahmed-abdelhamed"
     *                      ),
     *                      @OA\Property(
     *                         property="targetBlog_id",
     *                         type="string/integer",
     *                         example="t:nrXV2XvboWHMYIHJGCl"
     *                      ),
     *                      @OA\Property(
     *                         property="fromBlogName",
     *                         type="string",
     *                         example="abdullah-alshawafi"
     *                      ),
     *                      @OA\Property(
     *                         property="fromBlogid",
     *                         type="string/integer",
     *                         example="t:T7U1RijeZIfSsttMS7dYjw"
     *                      ),
     *                      @OA\Property(
     *                         property="targetPostId",
     *                         type="integer",
     *                         example=666925284723982336
     *                      ),
     *                      @OA\Property(
     *                         property="targetPostSummary",
     *                         type="string",
     *                         example="hi it is a very nice day"
     *                      ),
     *                      @OA\Property(
     *                         property="mediaUrl",
     *                         type="string",
     *                         example="https://64.media.tumblr.com/e861484f7a4fce4e/63d1a2478316-bb/s75x7b91d6a7.jpg",
     *                         description ="return only one image of the post or none if not images"
     *                      ),
     *                      @OA\Property(
     *                         property="reblogKey",
     *                         type="string",
     *                         example="3bHZPzR2",
     *                      ),
     *                      @OA\Property(
     *                         property="addedText",
     *                         type="string",
     *                         example="",
     *                      ),
     *                      @OA\Property(
     *                         property="is_anonymous",
     *                         type="boolean",
     *                         example=false,
     *                      ),
     *                  @OA\Property(property="tags[]", type="string", 
     *                          example="['winter','summer']"               
     *                       ),
     *                ),
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="type",
     *                         type="string",
     *                         example="reblog"
     *                      ),
     *                      @OA\Property(
     *                         property="timestamp",
     *                         type="integer",
     *                         example=1636069200
     *                      ),
     *                      @OA\Property(
     *                         property="targetTumblelogName",
     *                         type="string",
     *                         example="ahmed-abdelhamed"
     *                      ),
     *                      @OA\Property(
     *                         property="targetTumblelog_id",
     *                         type="string/integer",
     *                         example="t:nrXV2XvboWHMYIHJGCl"
     *                      ),
     *                      @OA\Property(
     *                         property="fromTumblelogName",
     *                         type="string",
     *                         example="yousiflasheen"
     *                      ),
     *                      @OA\Property(
     *                         property="fromTumblelog_id",
     *                         type="string/integer",
     *                         example="t:T7U1RijeZIfSsttMS7dYjw"
     *                      ),
     *                      @OA\Property(
     *                         property="targetPostId",
     *                         type="integer",
     *                         example=666953079544037376
     *                      ),
     *                      @OA\Property(
     *                         property="targetPostSummary",
     *                         type="string",
     *                         example="hi it is a v"
     *                      ),
     *                      @OA\Property(
     *                         property="mediaUrl",
     *                         type="string",
     *                         example="https://64.media.tumblr.com/e861484f7a4fce4e/63d1a2478316-bb/s75x7b91d6a7.jpg",
     *                         description ="return only one image of the post or none if not images"
     *                      ),
     *                      @OA\Property(
     *                         property="reblogKey",
     *                         type="string",
     *                         example="3bHZPzR2",
     *                      ),
     *                      @OA\Property(
     *                         property="addedText",
     *                         type="string",
     *                         example="hello",
     *                      ),
     *                      @OA\Property(
     *                         property="is_anonymous",
     *                         type="boolean",
     *                         example=false,
     *                      ),
     *                  @OA\Property(property="tags[]", type="string", 
     *                          example="['winter']"               
     *                       ),
     *                ),
     *               ),           
     *           ),
     *        ),
     *  ),
     *  security ={{"bearer":{}}},
     * )
     */

    
    /**
     * get notifications of a certain blog
     * 
     * @return response
     */

    public function GetNotifications($blogName)
    {
        //call service
        [$code,$notis]=(new NotificationsService())->GetNotifications($blogName,auth()->user());

        // $notis = Notification::latest()->get()->groupBy(function($item){ return $item->created_at->format('d-M-y'); });
        // $notis=Notification::latest()->get();

        //return the response
        if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'blogName not found',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not a member of the blog',403);
        else
            return $this->success_response(new NotificationCollection($notis),200);

    }

    /**
     * set a notification to be seen
     * 
     * @return response
     */

    public function SeeNotification($notificationId)
    {
        //call servic to do the logic
        $code=(new NotificationsService())->SeeNotification($notificationId,auth()->user());
    
        //return the response
        if($code==404)
            return $this->error_response(Errors::ERROR_MSGS_404,'notification id not found',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not a member of the blog',403);
        else
            return $this->success_response('the notification is set as seen',200);

    }

}
