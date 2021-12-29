<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogSettings;
use Illuminate\Http\Request;
use App\Http\Misc\Helpers\Errors;
use Illuminate\Support\Facades\Gate;

class BlogSettingsController extends Controller
{
  /**
   *	@OA\Get
   *	(
   * 		path="/blog/{Blog identifier}/settings/",
   * 		summary="Blog setting",
   * 		description="Retrieve Blog Setting for User.",
   * 		operationId="getBlogSettings",
   * 		tags={"Blog Settings"},
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
   *                         property="BlogTitle",
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
  public function getBlogSettings(Request $request, $blog_name)
  {
    $blog = Blog::where('blog_name', $blog_name)->first();

    // Check if the blog exists
    if (!$blog) {
      return $this->error_response(Errors::ERROR_MSGS_404, 'Blog not found', 404);
    }

    // Check if the authenticated request can view this blog's settings
    if (Gate::denies('control-blog-settings', $blog)) {
      return $this->error_response(Errors::ERROR_MSGS_403, '', 403);
    }

    $settings = BlogSettings::where('blog_id', $blog->id)->first();

    unset($settings['id']);
    unset($settings['blog_id']);

    $response = [
      'blog_title' => $blog->title,
      'blog_name' => $blog->blog_name,
      'settings' => $settings
    ];

    return $this->success_response($response);
  }

  /**
   * @OA\Put(
   * path="/blog/{blog-identifier}/settings/save",
   * summary="save specific blog setting",
   * description="user can save changes in one of its blogs",
   * operationId="saveBlogSettings",
   * tags={"Blog Settings"},
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
   *         name="allow_submit_posts",
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
   *       property="allow_submit_posts",
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
  public function saveBlogSettings(Request $request, $blog_name)
  {
    $blog = Blog::where('blog_name', $blog_name)->first();

    // Check if the blog exists
    if (!$blog) {
      return $this->error_response(Errors::ERROR_MSGS_404, 'Blog not found', 404);
    }

    // Check if the authenticated request can edit this blog's settings
    if (Gate::denies('control-blog-settings', $blog)) {
      return $this->error_response(Errors::ERROR_MSGS_403, '', 403);
    }

    $blog_title = $request->get('blog_title');
    $blog_name = $request->get('blog_name');

    if ($blog_title) {
      $success = Blog::where('id', $blog->id)->update(['title' => $blog_title]);

      if (!$success) {
        return $this->error_response(Errors::ERROR_MSGS_500, 'Error while updating blog title', 500);
      }
    }

    if ($blog_name) {
      $success = Blog::where('id', $blog->id)->update(['blog_name' => $blog_name]);

      if (!$success) {
        return $this->error_response(Errors::ERROR_MSGS_500, 'Error while updating blog username', 500);
      }
    }

    $success = BlogSettings::where('blog_id', $blog->id)->update($request->except('blog_title', 'blog_name'));

    if (!$success) {
      return $this->error_response(Errors::ERROR_MSGS_500, 'Error while saving blog settings', 500);
    }

    return $this->success_response($request->all());
  }
}