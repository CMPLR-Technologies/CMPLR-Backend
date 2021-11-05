<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
    * @OA\GET(
    * path="user/info",
    * summary=" retrieving the user’s account information ",
    * description="This method can be used to  retrieve the user’s account information that matches the OAuth credentials submitted with the request",
    * operationId="index",
    * tags={"users"},
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
    *             @OA\Property(property="following", type="Number", example=263),
    *             @OA\Property(property="default_post_format", type="String",description="html, markdown, or raw", example="html"),     
    *             @OA\Property(property="name", type="String",description="The user's tumblr short name", example="derekg"),      
    *             @OA\Property(property="likes", type="Number",description="The total count of the user's likes", example=606),                                            
    *             @OA\Property(property="blogs", type="array",
    *                @OA\Items(
    *                      @OA\Property(
    *                         property="name",
    *                         description="the short name of the blog",
    *                         type="String",
    *                         example="derekg",
    *                      ),
    *                      @OA\Property(
    *                         property="url",
    *                         description="the URL of the blog",
    *                         type="String",
    *                         example=  "https://derekg.org/",
    *                      ),
    *                      @OA\Property(
    *                         property="title",
    *                         type="String",
    *                         description="the title of the blog",
    *                         example= "Derek Gottfrid",
    *                      ),
    *                      @OA\Property(
    *                         property="primary",
    *                         type="Boolean",
    *                         description="indicates if this is the user's primary blog",
    *                         example=true
    *                      ),
    *                    @OA\Property(
    *                         property="followers",
    *                         type="Number",
    *                         description="total count of followers for this blog",
    *                         example= 33004929
    *                      ),
    *                      @OA\Property(
    *                         property="tweet",
    *                         type="String",
    *                         description="indicate if posts are tweeted auto, Y, N",
    *                         example= "Y"
    *                      ),
    *                        @OA\Property(
    *                         property="facebook",
    *                         type="String",
    *                         description="indicate if posts are sent to facebook Y, N",
    *                         example= "auto"
    *                      ),
    *                       @OA\Property(
    *                         property="type",
    *                         type="String",
    *                         description="indicates whether a blog is public or private",
    *                         example= "public"
    *                      ),
    *                ),
    *       
    *               ),           
    *           ),
    *        ),
    *     )
    * )
    */

    /**
     * Display a listing of user info.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index()
    {
        //
    }
   /**
    * @OA\GET(
    * path="user/dashboard",
    * summary=" retrieving the user’s dashboard",
    * description="This method can be used to  retrieve the user’s dashboard that matches the OAuth credentials submitted with the request",
    * operationId="index",
    * tags={"users"},
     *   @OA\Parameter(
     *      name="limit",
     *      description="The number of results to return: 1–20, inclusive",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="offset",
     *      description="Post number to start at",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="type",
     *      description="The type of post to return. Specify one of the following: text, photo, quote, link, chat, audio, video, answer",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="since_id",
     *      description="Return posts that have appeared after this ID; Use this parameter to page through the results: first get a set of posts, and then get posts since the last ID of the previous set.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="reblog_info",
     *      description="Indicates whether to return reblog information (specify true or false). Returns the various reblogged_ fields.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="notes_info",
     *      description="Indicates whether to return notes information (specify true or false). Returns note count and note metadata.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     * 
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
     *         @OA\JsonContent(
   *          type="object",
    *               @OA\Property(property="Meta", type="object",
    *               @OA\Property(property="Status", type="integer", example=200),
    *                @OA\Property(property="msg", type="string", example="OK"),
    *               ),
    *             @OA\Property(property="response", type="object",
    *          @OA\Property(property="posts", type="array", 
    *                   @OA\Items(
    *                         @OA\Property(
    *                         property="blog_name",
    *                         type="string",
    *                         example="laughingsquid"
    *                      ),    
    *                        @OA\Property(
    *                         property="id",
    *                         type="Number",
    *                         example=6828225215
    *                      ), 
    *                        @OA\Property(
    *                         property="post_url",
    *                         type="string",
    *                         example="https:\/\/links.laughingsquid.com\/post\/6828225215"
    *                      ),    

    *                
    *               
    *                   ),    
    *           ),
    *        ),
     *         ),

     *     ),
     * 
        * )
        */


    /**
     * Display a dashboard of user info.
     *
     * @return \Illuminate\Http\Response
     */  
    public function getDashboard()
    {
        //
    }

       /**
    * @OA\GET(
    * path="user/likes",
    * summary="Retrieve a User's Likes",
    * description="retrieve the posts liked by the user",
    * operationId="getUserLikes",
    * tags={"users"},
    *
    *   @OA\Parameter(
    *      name="limit",
    *      description="the number of posts to return",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="Number"
    *      )
    *   ),
    *    @OA\Parameter(
    *      name="offset",
    *      description="The number of the liked post to start from",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="Number"
    *      )
    *   ),
    *    @OA\Parameter(
    *      name="before",
    *      description="Retrieve posts liked before the specified timestamp",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="Number"
    *      )
    *   ),
    *    @OA\Parameter(
    *      name="after",
    *      description="Retrieve posts liked after the specified timestamp",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="Number"
    *      )
    *   ),
    *    
    *    @OA\RequestBody(
    *      required=true,
    *      description="Pass user credentials",
    *      @OA\JsonContent(
    *      @OA\Property(property="limit", type="integer", format="integer", example=1),
    *      @OA\Property(property="offset", type="integer", format="integer", example=1),
    *      @OA\Property(property="before", type="integer", format="integer", example=1),
    *      @OA\Property(property="after", type="integer", format="integer", example=1),
    *      ),
    *    ),
    *
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
    * 
    * )
    */

    public function getLikes()
    {
        //
    }


       /**
    * @OA\GET(
    * path="user/following",
    * summary="Retrieve the Blogs a User Is Following",
    * description="Used to return the blogs followed by the user, and info about those blogs.",
    * operationId="getUserFollowing",
    * tags={"users"},
    *
    *   @OA\Parameter(
    *      name="limit",
    *      description="the number of blogs to return",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="Number"
    *      )
    *   ),
    *    @OA\Parameter(
    *      name="offset",
    *      description="The number of the post to start from",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="Number"
    *      )
    *   ),
    *    
    *    @OA\RequestBody(
    *      required=true,
    *      description="Pass user credentials",
    *      @OA\JsonContent(
    *      @OA\Property(property="limit", type="integer", format="integer", example=1),
    *      @OA\Property(property="offset", type="integer", format="integer", example=1),
    *      ),
    *    ),
    *
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
    * 
    * )
    */
    public function getFollowing()
    {
        //
    }


   
   


    /**
    * @OA\Get(
    * path="user/filtered_tags",
    * summary="Retrieve Tag Filtering",
    * description="Retrieve a list of currently-filtered tag strings.",
    * operationId="UserGetFilteredTags",
    * tags={"users"},
    *
    *    @OA\RequestBody(
    *      required=true,
    *      description="Pass user credentials",
    *    ),
    *
    * @OA\Response(
    *    response=404,
    *    description="Not Found",
    * ),
    * @OA\Response(
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
    *
    *    @OA\Property(property="filtered_tags", type="array",
    *           @OA\Items(
    *               @OA\Property(property="tag1", type="string", example="techonolgy"),
    *               @OA\Property(property="tag2", type="string", example="something"),
    *               @OA\Property(property="tag3", type="string", example="something else"),
    *               )
    *           ),
    *        ),
    *     )
    * )
    */
    public function getFilteredTags()
    {
        //
    }


    /**
    * @OA\Post(
    * path="user/filtered_tags",
    * summary="Add Tag Filtering",
    * description="Add one or more tags to filter.",
    * operationId="UserPostFilterTag",
    * tags={"users"},
    *
    *   @OA\Parameter(
    *      name="filtered_tags",
    *      description="One or more than one tag string to add to your list of filters",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="array of strings"
    *      )
    *   ),
    *    
    *    @OA\RequestBody(
    *      required=true,
    *      description="Pass user credentials",
    *      @OA\JsonContent(
    *      required={"filtered_tags"},
    *      @OA\Property(property="filtered_tags", type="array",
    *           @OA\Items(
    *               @OA\Property(property="tag1", type="string", example="techonolgy"),
    *               @OA\Property(property="tag2", type="string", example="something"),
    *               @OA\Property(property="tag3", type="string", example="something else"),
    *               )
    *           ),    
    *    ),
    *   ),
    *
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
    *        )
    * )
    */
    public function createFilteredTags()
    {
        //
    }



    /**
    *	@OA\Delete
    *	(
    * 		path="user/filtered_tags/{tag}",
    * 		summary="Remove Tag Filtering",
    * 		description="Remove a tag filter.",
    * 		operationId="UserDeleteFilteringTag",
    * 		tags={"users"},
    *
    *   	@OA\Parameter
    *		(
    *      		name="tag",
    *      		description="Tag to stop filtering",
    *      		in="path",
    *      		required=true,
    *      		@OA\Schema
    *			(
    *           		type="string"
    *      		)
    *   	),
    *    
    *    	@OA\RequestBody
    *		(
    *      		required=true,
    *      		description="Pass user credentials",
    *      		@OA\JsonContent
    *			(
    *	    			required={"tag"},
    *      			@OA\Property(property="tag", type="string", format="text", example="football"),
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
    public function removeFilteredTags()
    {
        //
    }

    /**
    *	@OA\Get
    *	(
    * 		path="user/filtered_content",
    * 		summary="Retrieve Content Filtering",
    * 		description="Retrieve a list of currently-filtered content strings.",
    * 		operationId="UserGetFilteredContent",
    * 		tags={"users"},
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
    *					property="Meta", type="object",
    *					@OA\Property(property="Status", type="integer", example=200),
    *					@OA\Property(property="msg", type="string", example="OK"),
    *        		),
    *
    *       			@OA\Property
    *				    (
    *             			@OA\Property
    *					    (
    *						        property="filtered_content", type="array",
    *                				@OA\Items
    *						        (
    *			        	              @OA\Property(property="tag1_content",example="technology"),
    *			        	              @OA\Property(property="tag2_content",example="something"),
    *			        	        ),
    *       
    *               		),           
    *           		),
    *        	),
    *     	)
    * )
    */
    public function getFilteredContent()
    {

    }

    /**
    *	@OA\Post
    *	(
    * 		path="user/filtered_content",
    * 		summary="Add Content Filtering",
    * 		description="Add one or more content strings to filter.",
    * 		operationId="UserPostFilteringContent",
    * 		tags={"users"},
    *
    *   	@OA\Parameter
    *		(
    *      		name="filtered_content",
    *      		description="One or more than one string to add to your list of filters",
    *      		in="query",
    *      		required=true,
    *      		@OA\Schema
    *			(
    *           		type="array of strings"
    *      		)
    *   	),
    *    
    *    	@OA\RequestBody
    *		(
    *      		required=true,
    *      		description="Pass user credentials",
    *      		@OA\JsonContent
    *			(
    *	    		required={"filtered_content"},
    *               @OA\Property(property="filtered_tags", type="array",
    *                   @OA\Items
    *                   (
    *                       @OA\Property(property="tag1", type="string", example="techonolgy"),
    *                       @OA\Property(property="tag2", type="string", example="something"),
    *                       @OA\Property(property="tag3", type="string", example="something else"),
    *                   )
    *               )
    *           ),      
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
    public function createFilteredContent()
    {

    }

    /**
    *	@OA\Delete
    *	(
    * 		path="user/filtered_content",
    * 		summary="Remove filtered_content",
    * 		description="rRemove a content filter string.",
    * 		operationId="UserDeleteFilteringContent",
    * 		tags={"users"},
    *
    *   	@OA\Parameter
    *		(
    *      		name="filtered_content",
    *      		description="Content filter string to remove.",
    *      		in="path",
    *      		required=true,
    *      		@OA\Schema
    *			(
    *           		type="string"
    *      		)
    *   	),
    *    
    *    	@OA\RequestBody
    *		(
    *      		required=true,
    *      		description="Pass user credentials",
    *      		@OA\JsonContent
    *			(
    *	    		required={"filtered_content"},
    *      			@OA\Property(property="filtered_content", type="string", format="text", example="hello_filter"),
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
    public function removeFilteredContent()
    {

    }

  

    
      
    /**
    * @OA\Delete(
    ** path="/{blog-identifier}/notes/delete",
    *   tags={"users"},
    *   summary="unfollow tag",
    *   operationId="unfollow tag",
    *  @OA\Parameter(
    *      name="post_id",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="string"
    *      )
    *   ),
    *  @OA\Parameter(
    *      name="note_tumblelog",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="string"
    *      ),
    *   description="the name of blog containing post",
    *   ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="ok"),
    *           ),
    *       ),
    *         
    *          
    *       ),
    *)
    **/
    public function UserDeleteNote()
    {

    }

    // 7ta fy blogs b3d check

    /**
    * @OA\Post(
    ** path="blog/{blog-identifier}/subscription",
    *   tags={"Blog"},
    *   summary="subscription a blog",
    *   operationId="subscription",
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="ok"),
    *           ),
    *       ),
    *            
    *    ),
    *)
    **/
    public function BlogSubscription()
    {

    }

    /**
    * @OA\Delete(
    ** path="blog/{blog-identifier}/subscription",
    *   tags={"Blog"},
    *   summary="subscription a blog",
    *   operationId="Unsubscription",
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *  @OA\Parameter(
    *      name="post_id",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *           type="string"
    *      )
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="ok"),
    *           ),
    *       ),
    *            
    *    ),
    *)
    **/
    public function BlogUnSubscription()
    {

    }


    //https://www.tumblr.com/mega-editor/published/ahmed-abdelhamed

    /**
    * @OA\Post(
    ** path="{blog-identifier}/add_tags_to_posts",
    *   tags={"Blog"},
    *   summary="add new tag(s) to existing post(s)",
    *   operationId="Add Tags to Posts",
    *  @OA\Parameter(
    *         name="posts_id[]",
    *         in="query",
    *         required=true,
    *         @OA\Schema(
    *         type="array",
    *              @OA\Items(type="string")
    *          )
    *      ),
    *  @OA\Parameter(
    *         name="tag[]",
    *         in="query",
    *         required=true,
    *         @OA\Schema(
    *         type="array",
    *              @OA\Items(type="string")
    *          )
    *      ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="ok"),
    *           ),
    *       ),
    *            
    *    ),
    *)
    **/
    public function AddTagsToPosts()
    {

    }

    /**
    * @OA\Delete(
    ** path="{blog-identifier}/delete_posts",
    *   tags={"posts"},
    *   summary="user can delete one or more posts",
    *   operationId="DeletePosts",
    *  @OA\Parameter(
    *      name="posts_id[]",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *      type="array",
    *            @OA\Items(type="integer/string")
    *          )
    *      ),
    *  @OA\Parameter(
    *      name="tags[]",
    *      in="query",
    *      required=true,
    *      @OA\Schema(
    *      type="array",
    *            @OA\Items(type="string")
    *          ),
    *      ),
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"posts_id[]","tags[]"},
    *       @OA\Property(property="posts_id[]", type="string", 
    *                   example="[1123153153,153151312]"               
    *                   ),
    *       @OA\Property(property="tags[]", type="string", 
    *                   example="['winter','153151312']"               
    *                   ),
    *    ),
    * ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="ok"),
    *           ),
    *       ),
    *            
    *    ),
    *)
    **/
    public function DeletePosts(Request $request)
    {

    }


    /**
    * @OA\Post(
    ** path="{blog-identifier}/get_tags_for_posts",
    *   tags={"Blog"},
    *   summary="get all tag(s) existing in post(s)",
    *   operationId="get_tags_for_posts",
    *  @OA\Parameter(
    *         name="posts_id[]",
    *         in="query",
    *         required=true,
    *         @OA\Schema(
    *         type="array",
    *              @OA\Items(type="string/integer")
    *          )
    *      ),
    *   @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"posts_id[]"},
    *       @OA\Property(property="posts_id[]", type="string", 
    *                   example="[1123153153,153151312]"               
    *                   ),
    *       ),
    *   ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *              @OA\Property(property="Status", type="integer", example=200),
    *              @OA\Property(property="msg", type="string", example="ok"),
    *           ),
    *           @OA\Property(property="response", type="object",
    *              @OA\Property(property="number of tags", type="integer", example=3),
    *              @OA\Property(property="posts_id[]", type="string", 
    *                   example="['summer','sunny','beach'd]"               
    *                  ),
    *           ),
    *       ),
    *            
    *    ),
    *    security ={{"bearer":{}}}
    *)
    **/
    // check if post or get 
    public function get_tags_for_posts()
    {

    }


    /**
    * @OA\Delete(
    ** path="{blog-identifier}/remove_tags_from_posts",
    *   tags={"Blog"},
    *   summary="remove tag(s) existing in post(s)",
    *   operationId="remove_tags_from_posts",
    *  @OA\Parameter(
    *         name="posts_id[]",
    *         in="query",
    *         required=true,
    *         @OA\Schema(
    *         type="array",
    *              @OA\Items(type="string/integer")
    *          )
    *      ),
    *   @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"posts_id[]"},
    *       @OA\Property(property="posts_id[]", type="string", 
    *                   example="[1123153153,153151312]"               
    *                   ),
    *       ),
    *   ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not Found"
    *   ),
    *   @OA\Response(
    *          response=200,
    *          description="Success",
    *       ),
    *            
    *  security ={{"bearer":{}}},
    *)
    **/
    public function remove_tags_from_posts()
    {

    }




}
