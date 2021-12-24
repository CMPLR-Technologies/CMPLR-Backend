<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\UserInfoCollection;
use App\Http\Resources\UserInfoResource;
use App\Http\Resources\UserResource;
use App\Models\Blog;
use App\Models\BlogUser;
use App\Models\PostNotes;
use App\Models\Posts;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $UserService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    /**
     * @OA\Get(
     * path="/info",
     * summary=" retrieving the user’s account information ",
     * description="This method can be used to  retrieve the user’s account information that matches the OAuth credentials submitted with the request",
     * operationId="index",
     * tags={"Users"},
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
     *     ),
     * security ={{"bearer":{}}}
     * )
     */
    
    /**
    * This function Get User Info
    *
    */
    public function GetUserInfo(Request $request) 
    {
        //Get authenticated user
        $user  = $this->UserService->GetAuthUser();
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        
        //Get User Data 
        $user_data = $this->UserService->GetUserData($user);
        if(!$user_data)
            return $this->error_response(Errors::ERROR_MSGS_500, 'Failed to get User data', 500);
       
        // get number of followers of user
        $following_count = $this->UserService->GetUserFollowing($user->id);
        $user_data['following_counts']=  $following_count;
        // get number of posts of user
        $user_posts = $this->UserService->GetUserPosts($user);
        $user_data['posts_count']=  $user_posts;
        //Get Blog Data 
        $blogs_data = $this->UserService->GetBlogsData($user->id);
        if(!$blogs_data)
            return $this->error_response(Errors::ERROR_MSGS_500, 'Failed to get Blogs data', 500);
        // set the response
        // $response['user'] = $user_data;
        $response = $blogs_data;
        // $response = (object) array_merge(
        //     (array) $user_data, (array) $blogs_data);
        //$response = array_merge($user_data->toArray(), array($blogs_data));
        return $this->success_response(new UserInfoCollection($response));
    }

    /**
     * @OA\Get(
     * path="/user/dashboard",
     * summary=" retrieving the user’s dashboard",
     * description="This method can be used to  retrieve the user’s dashboard that matches the OAuth credentials submitted with the request",
     * operationId="index",
     * tags={"Posts"},
     * 
     * @OA\Response(
     *    response=200,
     *    description="Successfully",
     *  @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="success"),
     *           ),
     *          @OA\Property(property="response", type="object",
     *          @OA\Property(property="posts", type="array",
     *            @OA\Items(
     *              @OA\Property(property="post", type="object",
     *                     @OA\Property(property="post_id", type="integer", example= 123 ),
     *                     @OA\Property(property="type", type="string", example="text"),
     *                     @OA\Property(property="state", type="string", format="text", example="private"),
     *                     @OA\Property(property="content", type="string", format="text", example="<h1> hello all</h1><br/> <div><p>my name is <span>Ahmed</span></p></div>"),
     *                     @OA\Property(property="date", type="string", format="text", example="Monday, 20-Dec-21 21:54:11 UTC"),
     *                     @OA\Property(property="source_content", type="string", format="text", example="www.geeksforgeeks.com"),
     *                     @OA\Property(property="tags", type="string", format="text", example="['DFS','BFS']"),
     *                     @OA\Property(property="is_liked", type="boolean", example=true),
     *              ),
     *              @OA\Property(property="blog", type="object",
     *                     @OA\Property(property="blog_id", type="integer", example= 123 ),
     *                     @OA\Property(property="blog_name", type="string", format="text", example="Ahmed_1"),
     *                     @OA\Property(property="avatar", type="string", format="text", example="https://assets.tumblr.com/images/default_avatar/cone_closed_128.png"),
     *                     @OA\Property(property="avatar_shape", type="string", example="circle"),
     *                     @OA\Property(property="replies", type="string", format="text", example="everyone"),
     *                     @OA\Property(property="follower", type="boolean", example=true),
     *              ),
     *             ),
     *          ),
     *          @OA\Property(property="next_url", type="string", example= "http://127.0.0.1:8000/api/user/followings?page=2" ),
     *          @OA\Property(property="total", type="integer", example= 20 ),
     *          @OA\Property(property="current_page", type="integer", example= 1 ),
     *          @OA\Property(property="posts_per_page", type="integer", example=4),
     *          ),
     *       ),
     * ),
     *   @OA\Response(
     *      response=404,
     *       description="Not Found",
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="invalid Data",
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    public function GetDashboard(Request $request)
    {
        $user = Auth::user();
        //get all followed blogs
        $user_blogs = $user->blogs()->pluck('blog_id');
        $followed_blogs_id = $user->FollowedBlogs->pluck('id');
        // get posts of blogs that user follow or posts of user himself
        $Posts = Posts::whereIn('blog_id', $followed_blogs_id)->orWhereIn('blog_id', $user_blogs)->paginate(Config::PAGINATION_LIMIT);
        return $this->success_response(new PostsCollection($Posts));
    }

    /**
     * @OA\Get(
     * path="/user/likes",
     * summary="Retrieve a User's Likes",
     * description="retrieve the posts liked by the user",
     * operationId="getUserLikes",
     * tags={"Users"},
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
     *   
     *       @OA\Response
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
     *             			@OA\Property(property="total_posts", type="Number", example=263),
     *             			@OA\Property
     *					    (
     *						    property="posts", type="array",
     *                			@OA\Items
     *						    (
     *			        	        @OA\Property(property="post1",description="the first post",type="object"),
     *			        	        @OA\Property(property="post2",description="the second post",type="object"),
     *			        	        @OA\Property(property="post3",description="the third post",type="object"),
     *			        	    ),
     *       
     *               		),
     *           		),
     *        		),
     *     	),
     * security ={{"bearer":{}}}
     * )
     */
    public function GetUserLikes(Request $request)
    {
        //get auth user
        $user = Auth::user();
        // get id of all posts liked by user
        $likes = $this->UserService->GetLikes($user->id);
        //$likes = PostNotes::where('user_id',$user->id)->where('type','=','like')->pluck('post_id');

        //get liked posts
        $posts = Posts::whereIn('id',$likes)->paginate(config::PAGINATION_LIMIT);
        
        return $this->success_response(new PostsCollection($posts));
    }

    /**
     * @OA\Get(
     * path="/user/following",
     * summary="Retrieve the Blogs a User Is Following",
     * description="Used to return the blogs followed by the user, and info about those blogs.",
     * operationId="getUserFollowing",
     * tags={"Users"},
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
     * 
     *       @OA\Response
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
     *             			@OA\Property(property="total_blogs", type="Number", example=263),
     *             			@OA\Property
     *					    (
     *						    property="blogs", type="array",
     *                			@OA\Items
     *						    (
     *			        	        @OA\Property(property="blog1",description="the first blog",type="object"),
     *			        	        @OA\Property(property="blog2",description="the second blog",type="object"),
     *			        	        @OA\Property(property="blog3",description="the third blog",type="object"),
     *			        	    ),
     *       
     *               		),
     *           		),
     *        		),
     *     	),
     * security ={{"bearer":{}}}
     * 
     * )
     */
    public function getFollowing()
    {
        //
    }

    /**
     * @OA\Get(
     * path="/user/filtered_tags",
     * summary="Retrieve Tag Filtering",
     * description="Retrieve a list of currently-filtered tag strings.",
     * operationId="UserGetFilteredTags",
     * tags={"UserSettings"},
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
     * path="/user/filtered_tags",
     * summary="Add Tag Filtering",
     * description="Add one or more tags to filter.",
     * operationId="UserPostFilterTag",
     * tags={"UserSettings"},
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
     *	@OA\Delete(
     * 		path="/user/filtered_tags/{tag}",
     * 		summary="Remove Tag Filtering",
     * 		description="Remove a tag filter.",
     * 		operationId="UserDeleteFilteringTag",
     * 		tags={"UserSettings"},
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
     *	@OA\Get(
     * 		path="/user/filtered_content",
     * 		summary="Retrieve Content Filtering",
     * 		description="Retrieve a list of currently-filtered content strings.",
     * 		operationId="UserGetFilteredContent",
     * 		tags={"UserSettings"},
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
     *	@OA\Post(
     * 		path="/user/filtered_content",
     * 		summary="Add Content Filtering",
     * 		description="Add one or more content strings to filter.",
     * 		operationId="UserPostFilteringContent",
     * 		tags={"UserSettings"},
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
     *	@OA\Delete(
     * 		path="/user/filtered_content",
     * 		summary="Remove filtered_content",
     * 		description="rRemove a content filter string.",
     * 		operationId="UserDeleteFilteringContent",
     * 		tags={"UserSettings"},
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
     *   path="/{blog-identifier}/notes/delete",
     *   tags={"Users"},
     *   summary="Delete a note from a post",
     *   operationId="deleteNote",
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
     *   path="/blog/{blog-identifier}/subscription",
     *   tags={"Blogs"},
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
     * security ={{"bearer":{}}}
     *)
     **/
    public function BlogSubscription()
    {
    }

    /**
     * @OA\Delete(
     *   path="/blog/{blog-identifier}/subscription",
     *   tags={"Blogs"},
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
     * security ={{"bearer":{}}}
     *)
     **/
    public function BlogUnSubscription()
    {
    }


    //https://www.tumblr.com/mega-editor/published/ahmed-abdelhamed

    /**
     * @OA\Post(
     *   path="/{blog-identifier}/add_tags_to_posts",
     *   tags={"Blogs"},
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
     * security ={{"bearer":{}}}
     *)
     **/
    public function AddTagsToPosts()
    {
    }

    /**
     * @OA\Delete(
     *   path="/{blog-identifier}/delete_posts",
     *   tags={"Posts"},
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
     * security ={{"bearer":{}}}
     *)
     **/
    public function DeletePosts(Request $request)
    {
    }


    /**
     * @OA\Post(
     *   path="/{blog-identifier}/get_tags_for_posts",
     *   tags={"Blogs"},
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
     *   path="/{blog-identifier}/remove_tags_from_posts",
     *   tags={"Blogs"},
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

    public function GetUserTheme()
    {
        $user = Auth::user();
        $theme = $user->theme;
        $response['theme']=$theme;
        return $this->success_response($response,200);
    }

    public function UpdateUserTheme (Request $request)
    {
        $user = Auth::user();
        $theme = $request->theme;
        $check = User::where('id',$user->id)->update(array('theme'=> $theme));
        if(!$check)
            return $this->error_response(Errors::ERROR_MSGS_500,[''],500);
        return $this->success_response(['successfully update theme'],200);
    }
}
