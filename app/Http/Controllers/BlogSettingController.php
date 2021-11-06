<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogSettingController extends Controller
{
       /**
     *	@OA\Get
     *	(
     * 		path="settings/blog/{Blog identifier}",
     * 		summary="Blog setting",
     * 		description="Retrieve Blog Setting for User.",
     * 		operationId="GEtBlogSetting",
     * 		tags={"BlogSetting"},
     *
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
     *                      @OA\Property(
     *                         property="Blog_id",
     *                         type="string/integer",
     *                         example="12135515"
     *                      ),
     *                      @OA\Property(
     *                         property="BlogName",
     *                         type="string",
     *                         example="Summer Photos 2019"
     *                      ),
     *                      @OA\Property(
     *                         property="Blogtitle",
     *                         type="string",
     *                         example="summer"
     *                      ),    
     *                      @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         example="https://www.example.com/image/avatar.png"
     *                      ),   
     *                      @OA\Property(
     *                         property="Replies",
     *                         type="string",
     *                         example="Every can reply"
     *                      ), 
     *                      @OA\Property(
     *                         property="Ask",  type="object",
     *                           @OA\Property(
     *                              property="permit ask",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="Ask page title",
     *                              type="string",
     *                              example=""
     *                           ),  
     *                           @OA\Property(
     *                              property="permit anonymous questions",
     *                              type="Boolean",
     *                              example=false
     *                           ),                            
     *                         
     *                      ), 
     *                      @OA\Property(
     *                         property="Submissions",  type="object",
     *                           @OA\Property(
     *                              property="permit submit",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="Submissions page title",
     *                              type="string",
     *                              example="Submit a post"
     *                           ),  
     *                           @OA\Property(
     *                              property="Submissions guidelines",
     *                              type="string",
     *                              example="Don't violate the community rules"
     *                           ),    
     *                           @OA\Property(
     *                              property="is_text_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),   
     *                           @OA\Property(
     *                              property="is_photo_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="is_quote_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="is_link_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),
     *                           @OA\Property(
     *                              property="is_video_allowed",
     *                              type="Boolean",
     *                              example=true
     *                           ),                       
     *                         
     *                      ),
     *                     @OA\Property(
     *                        property="permit Messaging",
     *                        type="Boolean",
     *                        example=true
     *                     ),  
     *                     @OA\Property(
     *                        property="Protected",
     *                        type="Boolean",
     *                        example=false
     *                     ),  
     * 
     *                      @OA\Property(
     *                         property="Visibility",  type="object",
     *                           @OA\Property(
     *                              property="Dashboard_Hide",
     *                              type="Boolean",
     *                              example=false
     *                           ),
     *                           @OA\Property(
     *                              property="Search_Hide",
     *                              type="Boolean",
     *                              example=false
     *                           ),                             
     *                         
     *                      ), 
     * 
     *                     @OA\Property(
     *                        property="Queue", type="object",
     * 
     *                           @OA\Property(
     *                              property="posts_per_day",
     *                              type="integer",
     *                              example=3
     *                           ),
     *                           @OA\Property(
     *                              property="Between",
     *                              type="string",
     *                              example="12am,4pm"
     *                           ),                               
     *                     ),                   
     *                                  
     *                ),
     *            ),          
     *       ),
     *  security ={{"bearer":{}}}
     * )
     */
    public function BlogSetting()
    {

    }
      /**
     * @OA\PUT(
     * path="settings/blog/{blog-identifier}/save",
     * summary="save specfic blog setting",
     * description="user can save changes in one of its blogs",
     * operationId="blogSettingSave",
     * tags={"BlogSetting"},
     *  @OA\Parameter(
     *         name="Username",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="likes",
     *         in="query",
     *         description="make your likes public at blog_url", 
     *         required=false,
     *         @OA\Schema(
     *              type="boolean",
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="following",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="Replies",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="allow_ask",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="ask_page_title",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="allow_anonymous_questions",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="allow_sumbit_posts",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="submission_page_title",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="submission_guideline",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="is_text_allowed",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="is_photo_allowed",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="is_quote_allowed",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="is_link_allowed",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="is_video_allowed",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="allow_messages",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="dashboard_hide",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *              type="boolean"
     *         )
     *      ),
     *   @OA\Parameter(
     *         name="search_hide",
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
     *       property="Username",
     *       type="string",
     *       example="ahmed-abdelhamed1"
     *    ),
     *    @OA\Property(
     *       property="replies",
     *       type="string",
     *       example="Everyone can reply"
     *    ),
     *    @OA\Property(
     *       property="allow_ask",
     *       type="boolean",
     *       example=true
     *    ),
     *    @OA\Property(
     *       property="ask_page_title",
     *       type="string",
     *       example="hello ask me whatever you want"
     *    ),
     *    @OA\Property(
     *       property="allow_sumbit_posts",
     *       type="boolean",
     *       example=true
     *    ),
     *    @OA\Property(
     *       property="submission_guideline",
     *       type="string",
     *       example="submissions should follow community standards"
     *    ),
     *    @OA\Property(
     *       property="is_link_allowed",
     *       type="boolean",
     *       example=true
     *    ),
     *    @OA\Property(
     *       property="is_video_allowed",
     *       type="boolean",
     *       example=false
     *    ), 
     *  ),         
     * ),
     * @OA\Response(
     *    response=400,
     *    description="bad request",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=400),
     *           @OA\Property(property="msg", type="string", example="Bad Request"),
     *        ),
     *     ),
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
     *     ),
     *   ),
     *   security ={{"bearer":{}}},
     * )
     */
    public function BlogSettingSave()
    {

    }
}
