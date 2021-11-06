<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersettingController extends Controller
{
    /**
     *	@OA\Get
     *	(
     * 		path="/settings/account",
     * 		summary="User setting",
     * 		description="Retrieve Account Setting for User.",
     * 		operationId="accountSettings",
     * 		tags={"UserSettings"},
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="meta", type="object",
     *          @OA\Property(property="status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",          
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="example@gmail.com"
     *                      ),
     *                      @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         example="password123"
     *                      ),
     *                      @OA\Property(
     *                         property="google_login",
     *                         type="Boolean",
     *                         example=false
     *                      ),    
     *                      @OA\Property(
     *                         property="account_activity",
     *                         type="Boolean",
     *                         example=true
     *                      ),   
     *                      @OA\Property(
     *                         property="two-factor_authentication",
     *                         type="Boolean",
     *                         example=false
     *                      ), 
     *                      @OA\Property(
     *                         property="filtering_tags",
     *                         type="string",
     *                         example="summer,winter,sunny"
     *                      ), 
                       
     *                  ),
     *                ),          
     *   ),
     * security ={{"bearer":{}}}
     * )
     */

    public function accountSettings()
    {
    }

    /**
     * @OA\Delete(
     *   path="/settings/account/delete",
     *   summary="Delete User Account",
     *   description="This method is used to delete the account of the authenticated user.",
     *   operationId="deleteAccount",
     *   tags={"UserSettings"},
     *
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     *   ),
     *  
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       )
     *     )
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    public function deleteAccount()
    {
    }


    /**
     * @OA\POST(
     *     path="/settings/notifications",
     *     summary="Retrieve Notifications Setting for User.",
     * 		operationId="get_notification_setting",
     *     tags={"UserSettings"},
     *  @OA\Response(
     *      response=200,
     *        description = "Url Example: api.tumblr.com/v2/settings/notifications",
     *        @OA\JsonContent(
     *             type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *             @OA\Property(
     *                property="blogs",
     *                type="array",
     *                example={{
     *                  "Blog_name": "summer memories",
     *                  "blog_id": 13515315315,
     *                  "blog_title": "summer22",
     *                  "blog_avatar": "https://www.example.com/image/avatar.png",
     *                  "email_about_new_follower": true,
     *                  "email_about_new_replies": true,
     *                  "email_about_new_submissions": true,
     *                  "email_about_mentions": true,
     *                  "email_about_new_asks": true,
     *                  "notify_form": "from everyone",
     *                  "applly_to_all_blogs":false,
     *                }, {
     *                  "Blog_name": "summer memories 2 ",
     *                  "blog_id": 13515315314,
     *                  "blog_title": "summer21",
     *                  "blog_avatar": "https://www.example.com/image/avatar.png",
     *                  "email_about_new_follower": false,
     *                  "email_about_new_replies": true,
     *                  "email_about_new_submissions": true,
     *                  "email_about_mentions": false,
     *                  "email_about_new_asks": true,
     *                  "notify_form": "from people you follow",
     *                  "applly_to_all_blogs":false,
     *                }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="Blog_name",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="blog_id",
     *                         type="integer",
     *                      ),
     *                      @OA\Property(
     *                         property="blog_title",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="blog_avatar",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="email_about_new_follower",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="email_about_new_replies",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="email_about_new_submissions",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="email_about_mentions",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="email_about_new_asks",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="notify_form",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="applly_to_all_blogs",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *         @OA\Property(
     *            property="tumblr_news",
     *            type="Boolean",
     *            example=true
     *         ),
     *         @OA\Property(
     *            property="conversational_notifications",
     *            type="Boolean",
     *            example=true
     *         ),
     *      
     *        ),
     *     ),
     *
     * security ={{"bearer":{}}}
     * )
     */
    public function NotificationSetting()
    {
        //
    }


    /**
     *	@OA\Get
     *	(
     * 		path="/settings/dashboard",
     * 		summary="User dashboard setting",
     * 		description="Retrieve DashBoard Setting for User.",
     * 		operationId="GEtDashBoardSetting",
     * 		tags={"UserSettings"},
     *
     * @OA\Response(
     *    response=200,
     *    description="sucess",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",          
     *                      @OA\Property(
     *                         property="interface",
     *                         type="object",
     *                           @OA\Property(
     *                              property="enable_endless_scrolling",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="show_badge",
     *                              type="Boolean",
     *                              example=true
     *                           ),                               
     *                      ),
     *                      @OA\Property(
     *                         property="text_editor",
     *                         type="string",
     *                         example="Rich text editor"
     *                      ),
     *                      @OA\Property(
     *                         property="message sounds",
     *                         type="Boolean",
     *                         example=true
     *                      ),    
     *                      @OA\Property(
     *                         property="preferences",
     *                         type="object",
     *                           @OA\Property(
     *                              property="Include followed tag posts",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="best_stuff__first",
     *                              type="Boolean",
     *                              example=true
     *                           ),                               
     *                      ),                       
     *                  ),
     *                ),          
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    public function DashboardSetting()
    {
        //
    }


    /**
     * @OA\PUT(
     * path="/setting/account/save",
     * summary="{blog-identifier}/posts/draft",
     * description="user can get the draft posts",
     * operationId="Drafted_posts",
     * tags={"UserSettings"},
     *  @OA\Parameter(
     *         name="new_email",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="current_confirm_password",
     *         in="query",
     *         description="used as confirm_password for change accout email or current password for change password", 
     *         required=false,
     *         @OA\Schema(
     *              type="string",
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="new_password",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="google_login",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="account_activity",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="two-factor_authentication",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="filtered tags",
     *         in="query",
     *         required=false,
     *         example="winter,summer",
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="filtered post_content",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="enable_endless_scrolling",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="show_badge",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="text_editor",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="message sounds",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="best_stuff_first",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="include_followed_tags_posts",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="tumblr_news",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="conversation_notifications",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       type="object",
     *    @OA\Property(
     *       property="email",
     *       type="string",
     *       example="new_example@gmail.com"
     *    ),
     *    @OA\Property(
     *       property="current_confirm_password",
     *       type="string",
     *       example="new_pass123"
     *    ),
     *    @OA\Property(
     *       property="account_activity",
     *       type="boolean",
     *       example=true
     *    ),
     *    @OA\Property(
     *       property="two_factor_authentication",
     *       type="boolean",
     *       example=false
     *    ),
     * 
     *    @OA\Property(
     *       property="namea",
     *       type="string",
     *       example="ahmed"
     *    ),
     *    @OA\Property(
     *       property="Text Editor",
     *       type="string",
     *       example="Rich text editor"
     *    ), 
     *  ),         
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
     *     ),
     * security ={{"bearer":{}}}
     * )
     */

    public function UserSettingSave()
    {
    }
}