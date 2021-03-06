<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Http\Requests\Auth\ChangeEmailRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\SettingsRequest;
use App\Http\Resources\Auth\UserSettingResource;
use App\Services\User\UserSettingService;
use Illuminate\Support\Facades\Auth;

class UsersettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UsersettingController Controller
    |--------------------------------------------------------------------------|
    | This controller handles all about user settings 
    | view , update ,change email and password
    |
   */
    protected $UserSettingService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(UserSettingService $UserSettingService)
    {
        $this->UserSettingService = $UserSettingService;
    }
    /**
     *	@OA\Get
     *	(
     * 		path="user/settings",
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
    /**
     * Get AccountSetting Function Responisble for 
     * get all settings(account,dashboard,notification) to user
     * 
     * @return Response 
     */
    public function AccountSettings()
    {
        //get auth user
        $user = $this->UserSettingService->GetAuthUser();
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        // get user settings data    
        $data = $this->UserSettingService->GetSettings($user->id);
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_500, '', 500);
        // return user settings resource
        return $this->success_response(new UserSettingResource($data));
    }


    /**
     *	@OA\PUT
     *	(
     * 		path="user/settings/",
     * 		summary="User setting",
     * 		description="update Setting for User.",
     * 		operationId="getsettings",
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
     *     
     *       ),
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"content,blog_name,state,type"},
     *       @OA\Property(property="show_bagde", type="boolean", example=true),
     *    ),
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    /**
     * Update all User Settings
     * 
     * @param App\Http\Requests\SettingsRequest $request
     * 
     * @return response
     */
    public function UpdateSettings(SettingsRequest $request)
    {
        // get Auth User
        $user = $this->UserSettingService->GetAuthUser();
        if (!$user)
            return  $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        // get all the settings needed to be updated 
        $data = $request->all();
        //Update User Settings
        $is_updated = $this->UserSettingService->UpdateSettings($user->id, $data);
        if (!$is_updated)
            return $this->error_response(Errors::ERROR_MSGS_500, 'Failed to Update user settings', 500);

        return $this->success_response('', 200);
    }

    /**
     *	@OA\PUT
     *	(
     * 		path="settings/change_email",
     * 		summary="User change email",
     * 		description="update email for User.",
     * 		operationId="update email",
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
     *     
     *       ),
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"content,blog_name,state,type"},
     *       @OA\Property(property="email", type="string", example="ahmed@gmail.com"),
     *       @OA\Property(property="password", type="string", example="**********"),
     *    ),
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    /**
     * update Email of Account
     * 
     * @param App\Http\Requests\Auth\ChangeEmailRequest $request
     *
     * @return response
     */
    public function ChangeEmail(ChangeEmailRequest $request)
    {
        //get Authenticated user
        $user = Auth::user();

        // check if the user want to change email enters correct password
        $check = $this->UserSettingService->ConfirmPassword($request->password, $user->password);
        if (!$check)
            return $this->error_response(Errors::ERROR_MSGS_400, 'Invalid password entered', 400);

        // if the user enters its previous email no need to futher work :)
        if ($request->email == $user->email)
            return $this->success_response($request->email, 200);

        // update User Email
        $is_updated = $this->UserSettingService->UpdateEmail($user->id, $request->email);
        if (!$is_updated)
            return $this->error_response(Errors::ERROR_MSGS_500, 'Failed to update email', 500);

        $response['email'] = $request->email;
        return $this->success_response($response, 200);
    }

    /**
     *	@OA\PUT
     *	(
     * 		path="settings/change_password",
     * 		summary="User change password",
     * 		description="update password for User.",
     * 		operationId="update password",
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
     *     
     *       ),
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"content,blog_name,state,type"},
     *       @OA\Property(property="password", type="string", example="**********"),
     *       @OA\Property(property="new_password", type="string", example="**********"),
     *       @OA\Property(property="new_password_confirmation", type="string", example="**********"),
     *    ),
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    /**
     * change Password of Account
     * @param ChangeEmailRequest $request
     *
     * @return response
     *
     */
    public function ChangePassword(ChangePasswordRequest $request)
    {
        // get the authenticated user
        $user = Auth::user();

        // check if the user want to change password enters correct password
        $check = $this->UserSettingService->ConfirmPassword($request->password, $user->password);
        if (!$check)
            return $this->error_response(Errors::ERROR_MSGS_400, 'Invalid password entered', 400);

        //check if the password not match
        if (strcmp($request->new_password, $request->confirm_new_password) !== 0)
            return  $this->error_response(Errors::ERROR_MSGS_400, 'Passwords don\'t match', 400);

        // check if new pass = old pass
        $check_password = $this->UserSettingService->CheckPassword($user->password, $request->new_password);
        if (!$check_password) {
            $error['password'] = [Errors::DUPLICATE_PASSWORD];
            return  $this->error_response(Errors::ERROR_MSGS_400, $error, 400);
        }

        // update User Password
        $is_updated = $this->UserSettingService->UpdatePassword($user->id, $request->new_password);
        if (!$is_updated)
            return $this->error_response(Errors::ERROR_MSGS_500, 'Failed to update Password', 500);

        return $this->success_response('Password Change Successfully');
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