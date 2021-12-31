<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogSettings;
use Illuminate\Http\Request;
use App\Http\Misc\Helpers\Errors;
use App\Models\Posts;
use Illuminate\Support\Facades\Gate;

class BlogSettingsController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | BlogSettingsController Controller 
    |--------------------------------------------------------------------------|
    | This controller handles getting and saving blogs' settings 
    |
   */

  /**
   *	@OA\Get
   *	(
   * 		path="/blog/{blog-identifier}/settings",
   * 		summary="Get specific blog setting",
   * 		description="User can retrieve one of his blogs' settings",
   * 		operationId="GetBlogSettings",
   * 		tags={"Blog Settings"},
   *
   * @OA\Response(
   *    response=200,
   *    description="success",
   *    @OA\JsonContent(
   *       type="object",
   *       @OA\Property(property="meta", type="object",
   *          @OA\Property(property="Status", type="integer", example=200),
   *           @OA\Property(property="msg", type="string", example="success"),
   *        ),
   *       @OA\Property(property="response", type="object",
   *                      @OA\Property(
   *                         property="blog_title",
   *                         type="string",
   *                         example="summer"
   *                      ),    
   *                      @OA\Property(
   *                         property="blog_name",
   *                         type="string",
   *                         example="otako"
   *                      ),
   *                      @OA\Property(property="settings", type="object",
   *                         @OA\Property(
   *                            property="blog_id",
   *                            type="integer",
   *                            example=69
   *                         ),   
   *                         @OA\Property(
   *                            property="replies",
   *                            type="string",
   *                            example="everyone"
   *                         ),   
   *                         @OA\Property(
   *                            property="allow_ask",
   *                            type="boolean",
   *                            example=false
   *                         ),   
   *                         @OA\Property(
   *                            property="ask_page_title",
   *                            type="string",
   *                            example="Ask me anything"
   *                         ),   
   *                         @OA\Property(
   *                            property="allow_anonymous_question",
   *                            type="boolean",
   *                            example=false
   *                         ),   
   *                         @OA\Property(
   *                            property="allow_submissions",
   *                            type="boolean",
   *                            example=false
   *                         ),   
   *                         @OA\Property(
   *                            property="submission_page_title",
   *                            type="string",
   *                            example="Submit a post"
   *                         ),   
   *                         @OA\Property(
   *                            property="submission_guidelines",
   *                            type="string",
   *                            example="Don't submit useless post"
   *                         ),   
   *                         @OA\Property(
   *                            property="is_text_allowed",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="is_photo_allowed",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="is_link_allowed",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="is_quote_allowed",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="is_video_allowed",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="allow_messaging",
   *                            type="boolean",
   *                            example=false
   *                         ),   
   *                         @OA\Property(
   *                            property="posts_per_day",
   *                            type="integer",
   *                            example=2
   *                         ),   
   *                         @OA\Property(
   *                            property="posts_start",
   *                            type="integer",
   *                            example=0
   *                         ),   
   *                         @OA\Property(
   *                            property="posts_end",
   *                            type="integer",
   *                            example=0
   *                         ),   
   *                         @OA\Property(
   *                            property="dashboard_hide",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="search_hide",
   *                            type="boolean",
   *                            example=true
   *                         ),   
   *                         @OA\Property(
   *                            property="header_image",
   *                            type="string",
   *                            example="https://assets.tumblr.com/images/default_header/optica_pattern_02_640.png?_v=b976ee00195b1b7806c94ae285ca46a7"
   *                         ),   
   *                         @OA\Property(
   *                            property="avatar",
   *                            type="string",
   *                            example="https://assets.tumblr.com/images/default_avatar/cone_closed_128.png"
   *                         ),   
   *                         @OA\Property(
   *                            property="avatar_shape",
   *                            type="string",
   *                            example="circle"
   *                         ),   
   *                         @OA\Property(
   *                            property="background_color",
   *                            type="string",
   *                            example="white"
   *                         ),   
   *                         @OA\Property(
   *                            property="accent_color",
   *                            type="string",
   *                            example="blue"
   *                         ),   
   *                         @OA\Property(
   *                            property="description",
   *                            type="string",
   *                            example="Hello, I love CMPLR"
   *                         ),   
   *                         @OA\Property(
   *                            property="show_header_image",
   *                            type="boolean",
   *                            example=true
   *                         ), 
   *                         @OA\Property(
   *                            property="show_avatar",
   *                            type="boolean",
   *                            example=true
   *                         ), 
   *                         @OA\Property(
   *                            property="show_title",
   *                            type="boolean",
   *                            example=true
   *                         ), 
   *                         @OA\Property(
   *                            property="show_description",
   *                            type="boolean",
   *                            example=true
   *                         ),
   *                         @OA\Property(
   *                            property="use_new_post_type",
   *                            type="boolean",
   *                            example=true
   *                         ),
   *                      ),                       
   *                ),
   *            ),          
   *       ),
   *  security ={{"bearer":{}}}
   * )
   */
  /**
   * Get the blog settings if the blog belongs to auth user
   *
   * @param Request $request
   * @param string $blog_name
   * 
   * @return \Illuminate\Http\Response
   * 
   * @author Abdullah Adel
   */
  public function GetBlogSettings(Request $request, $blog_name)
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
   * summary="Save specific blog settings",
   * description="User can save changes in one of his blogs' settings",
   * operationId="SaveBlogSettings",
   * tags={"Blog Settings"},
   * @OA\RequestBody(
   *    required=true,
   *    description="You can pass any combination of one or more of the properties below",
   *    @OA\JsonContent(type="object",
   *       @OA\Property(
   *          property="blog_title",
   *          type="string",
   *          example="summer"
   *       ),    
   *       @OA\Property(
   *          property="blog_name",
   *          type="string",
   *          example="otako"
   *       ),  
   *       @OA\Property(
   *          property="replies",
   *          type="string",
   *          example="everyone"
   *       ),   
   *       @OA\Property(
   *          property="allow_ask",
   *          type="boolean",
   *          example=false
   *       ),   
   *       @OA\Property(
   *          property="ask_page_title",
   *          type="string",
   *          example="Ask me anything"
   *       ),   
   *       @OA\Property(
   *          property="allow_anonymous_question",
   *          type="boolean",
   *          example=false
   *       ),   
   *       @OA\Property(
   *          property="allow_submissions",
   *          type="boolean",
   *          example=false
   *       ),   
   *       @OA\Property(
   *          property="submission_page_title",
   *          type="string",
   *          example="Submit a post"
   *       ),   
   *       @OA\Property(
   *          property="submission_guidelines",
   *          type="string",
   *          example="Don't submit useless post"
   *       ),   
   *       @OA\Property(
   *          property="is_text_allowed",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="is_photo_allowed",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="is_link_allowed",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="is_quote_allowed",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="is_video_allowed",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="allow_messaging",
   *          type="boolean",
   *          example=false
   *       ),   
   *       @OA\Property(
   *          property="posts_per_day",
   *          type="integer",
   *          example=2
   *       ),   
   *       @OA\Property(
   *          property="posts_start",
   *          type="integer",
   *          example=0
   *       ),   
   *       @OA\Property(
   *          property="posts_end",
   *          type="integer",
   *          example=0
   *       ),   
   *       @OA\Property(
   *          property="dashboard_hide",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="search_hide",
   *          type="boolean",
   *          example=true
   *       ),   
   *       @OA\Property(
   *          property="header_image",
   *          type="string",
   *          example="https://assets.tumblr.com/images/default_header/optica_pattern_02_640.png?_v=b976ee00195b1b7806c94ae285ca46a7"
   *       ),   
   *       @OA\Property(
   *          property="avatar",
   *          type="string",
   *          example="https://assets.tumblr.com/images/default_avatar/cone_closed_128.png"
   *       ),   
   *       @OA\Property(
   *          property="avatar_shape",
   *          type="string",
   *          example="circle"
   *       ),   
   *       @OA\Property(
   *          property="background_color",
   *          type="string",
   *          example="white"
   *       ),   
   *       @OA\Property(
   *          property="accent_color",
   *          type="string",
   *          example="blue"
   *       ),   
   *       @OA\Property(
   *          property="description",
   *          type="string",
   *          example="Hello, I love CMPLR"
   *       ),   
   *       @OA\Property(
   *          property="show_header_image",
   *          type="boolean",
   *          example=true
   *       ), 
   *       @OA\Property(
   *          property="show_avatar",
   *          type="boolean",
   *          example=true
   *       ), 
   *       @OA\Property(
   *          property="show_title",
   *          type="boolean",
   *          example=true
   *       ), 
   *       @OA\Property(
   *          property="show_description",
   *          type="boolean",
   *          example=true
   *       ),
   *       @OA\Property(
   *          property="use_new_post_type",
   *          type="boolean",
   *          example=true
   *       ),                  
   *  ),         
   * ),
   * @OA\Response(
   *    response=400,
   *    description="Bad request",
   *    @OA\JsonContent(
   *       type="object",
   *       @OA\Property(property="meta", type="object",
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
   *    description="Success",
   *    @OA\JsonContent(
   *       type="object",
   *       @OA\Property(property="meta", type="object",
   *          @OA\Property(property="Status", type="integer", example=200),
   *           @OA\Property(property="msg", type="string", example="success"),
   *        ),
   *     ),
   *   ),
   *   security ={{"bearer":{}}},
   * )
   */
  /**
   * Save blog settings if the blog belongs to auth user
   *
   * @param Request $request
   * @param string $blog_name
   * 
   * @return \Illuminate\Http\Response
   * 
   * @author Abdullah Adel
   */
  public function SaveBlogSettings(Request $request, $blog_name)
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

      $success = Posts::where('blog_id', $blog->id)->update(['blog_name' => $blog_name]);

      if (!$success) {
        return $this->error_response(Errors::ERROR_MSGS_500, 'Error while updating related blog\'s related posts', 500);
      }
    }

    $success = BlogSettings::where('blog_id', $blog->id)->update($request->except('blog_title', 'blog_name'));

    if (!$success) {
      return $this->error_response(Errors::ERROR_MSGS_500, 'Error while saving blog settings', 500);
    }

    return $this->success_response([]);
  }
}