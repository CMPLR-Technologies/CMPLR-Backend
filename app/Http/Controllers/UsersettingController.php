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
     * 		operationId="GEtAccountSetting",
     * 		tags={"User"},
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
     *                         property="Email",
     *                         type="string",
     *                         example="example@gmail.com"
     *                      ),
     *                      @OA\Property(
     *                         property="Password",
     *                         type="string",
     *                         example="password123"
     *                      ),
     *                      @OA\Property(
     *                         property="GoogleLogin",
     *                         type="Boolean",
     *                         example=false
     *                      ),    
     *                      @OA\Property(
     *                         property="account_activity",
     *                         type="Boolean",
     *                         example=true
     *                      ),   
     *                      @OA\Property(
     *                         property="Two-factor_authentication",
     *                         type="Boolean",
     *                         example=false
     *                      ), 
     *                      @OA\Property(
     *                         property="filtteringTags",
     *                         type="string",
     *                         example="summer,winter,sunny"
     *                      ), 
                       
     *                  ),
     *                ),          
     *   ),
     * security ={{"bearer":{}}}
     * )
     */

    public function AccountSetting(){

    }


/**
 * @OA\POST(
 *     path="settings/notifications",
 *     summary="Retrieve Notifications Setting for User.",
 * 		operationId="get_notification_setting",
 *     tags={"User"},
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
     * 		tags={"User"},
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
     *                              property="show badge",
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
}
