<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *   path="/posts",
     *   tags={"posts"},
     *   summary="create new post",
     *   operationId="create",
     *   @OA\Parameter(
     *      name="content",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Array"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="layout",
     *      description="there are different types of layout for posts",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Array"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="state",
     *      description="the state of the post. Specify one of the following: published, draft, queue, private",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="publish_on",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="tags",
     *      description="Comma-separated tags for this post",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="date",
     *      description="The GMT date and time of the post, as a string",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="source_url",
     *      description="A source attribution for the post content",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="slug",
     *      description="Add a short text summary to the end of the post URL",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="send_to_twitter",
     *      description="Whether or not to share this via any connected Twitter account on post publish",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="is_private",
     *      description="Whether this should be a private answer, if this is an answer.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="send_to_facebook",
     *      description="Whether or not to share this via any connected Facebook account on post publish",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="parent_tumnlrlog_uuid ",
     *      description="the unique public identifier of the tumblelog that’s being reblogged from",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),  
     *  @OA\Parameter(
     *      name="parent_post_id",
     *      description=" the unique public post Id bing reblogged",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Integer"
     *      )
     *   ),  
     * @OA\Parameter(
     *      name="hide_trail",
     *      description="whether or not to hide the reblog trail with this new post",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="boolean"
     *      )
     *   ),  
     * @OA\Parameter(
     *      name="exclide_tral_items",
     *      description="reblog trail items",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Array"
     *      )
     *   ),  
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=201,
     *          description="Successfully Created",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=201),
     *           @OA\Property(property="msg", type="string", example="Created"),
     *           ),
     *           @OA\Property(property="response", type="object",
     *           @OA\Property(property="id", type="integer", example=1234567891234567),
     *           ),
     *       ),
     *         
     *          
     *       ),
     *)
     **/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * @OA\Put(
     ** path="/posts/edit",
     *   tags={"posts"},
     *   summary="Edit existing Post",
     *   operationId="edit",
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="the ID of the post to edit",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="id", type="number", format="text", example="12546899"),
     *    ),
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Successfully edited",
     *          @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *           ),
     *       ),
     *       ),
     *)
     **/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    
    /**
     * @OA\GET(
     ** path="/post/{post-id}",
     *   tags={"posts"},
     *   summary="fetch a post for editing",
     *   operationId="edit",
     *
     *   @OA\Parameter(
     *      name="post_fromat",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="successful post fetching",
     *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="OK"),
    *           ),
    *           @OA\Property(property="reponse", type="object",
    *           @OA\Property(property="object_type", type="String", example="post"),
    *           @OA\Property(property="type", type="string", example="text"),
    *           @OA\Property(property="id", type="string", example="2312145464"),
    *           @OA\Property(property="tumbllelog_uuid", type="string", example="yousiflasheen"),
    *           @OA\Property(property="parent_tumnlelog_uuid", type="string", example="john-abdelhamid"),
    *           @OA\Property(property="reblog_key", type="string", example="2312145464"),
    *           @OA\Property(property="trail", type="string", example="[, , ]"),
    *           @OA\Property(property="content", type="string", example="[hello everyboady]"),
    *           @OA\Property(property="layout", type="string", example="[1 ,3]"),
    *           
    *           ),
    *       ),
     *       ),
     *)
     **/

    public function edit(Posts $posts)
    {
        //
    }
    /**
     * @OA\PUT(
     ** path="/post/{post-id}",
     *   tags={"posts"},
     *   summary="edit posts with specific id",
     *   operationId="edit",
     *
     *   @OA\Parameter(
     *      name="all request parameters from post creation route are expected",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="object"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="successful post fetching",
     *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="OK"),
    *           ),
    *           @OA\Property(property="reponse", type="object",
    *           @OA\Property(property="post_id", type="String", example="1211464646"),
    *           
    *           ),
    *       ),
     *       ),
     *)
     **/



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posts $posts)
    {
        //
    }



    /**
     * @OA\GET(
     * path="/posts",
     * summary="blog/blog_url/posts/?",
     * description="user can get the posts published by certain blog",
     * operationId="published_posts",
     * tags={"posts"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="api_key",
     *         in="query",
     *         required=true,
     *         description="Your OAuth Consumer Key",
     *      ),
     *  @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         description="The type of post to return one of the following: text, quote, link, answer, video, audio, photo, chat",
     * ),
     *  @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         description="A specific post ID",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="tag[]",
     *         in="query",
     *         required=false,
     *         description="Limits the response to posts with all these specified tag(s),",
     *         @OA\Schema(
     *         type="array",
     *              @OA\Items(type="string")
     *          )
     *      ),
     *  @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         description="The number of posts to return",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="reblog_info",
     *         in="query",
     *         required=false,
     *         description="Indicates whether to return reblog information",
     *         @OA\Schema(
     *              type="Boolean"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="notes_info",
     *         in="query",
     *         required=false,
     *         description="Indicates whether to return notes information",
     *         @OA\Schema(
     *              type="Boolean"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         required=false,
     *         description="Indicates whether to return notes information default none",
     *         @OA\Schema(
     *              type="String"
     *         )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"blog-identifier","api_key"},
     *       @OA\Property(property="blog-identifier", type="string", format="text", example="summer_blog"),
     *       @OA\Property(property="api_key", type="string", format="string", example="??!"),
     *       @OA\Property(property="type", type="string", format="string", example="text"),
     *       @OA\Property(property="tag", type="string", example="summer"),
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
     *    description="sucess",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="total_users", type="integer", example=1235),           
     *             @OA\Property(property="Users", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="david"
     *                      ),
     *                      @OA\Property(
     *                         property="following",
     *                         type="Boolean",
     *                         example=true
     *                      ),
     *                      @OA\Property(
     *                         property="Url",
     *                         type="string",
     *                         example="https:www.davidslog.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updated",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                ),
     *               @OA\Items(
     *                      @OA\Property(
     *                         property="namea",
     *                         type="string",
     *                         example="ahmed"
     *                      ),
     *                      @OA\Property(
     *                         property="followinga",
     *                         type="Boolean",
     *                         example=true
     *                      ),
     *                      @OA\Property(
     *                         property="Urla",
     *                         type="string",
     *                         example="https:www.ahmed_a1.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updateda",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                  ),
     *               ),           
     *           ),
     *        ),
     *     )
     * )
     */

    public function RetrievePublishedPosts(Request $request, Posts $posts)
    {
    }


    /**
     * @OA\GET(
     * path="/posts/queue",
     * summary="{blog-identifier}/Retrieve Queued Posts",
     * description="user can get the posts that had been queued",
     * operationId="Queued_posts",
     * tags={"posts"},
     *  @OA\Parameter(
     *         name="Limit",
     *         in="query",
     *         required=false,
     *         description="The number of results to return",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         required=false,
     *         description="Specifies the post format to return(Html,MarkDown,Rich)",
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="Limit", type="integer",example=10),
     *       @OA\Property(property="filter", type="string", format="string", example="Html"),
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
     *    description="sucess",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="total_users", type="integer", example=1235),           
     *             @OA\Property(property="Users", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="david"
     *                      ),
     *                      @OA\Property(
     *                         property="following",
     *                         type="Boolean",
     *                         example=true
     *                      ),
     *                      @OA\Property(
     *                         property="Url",
     *                         type="string",
     *                         example="https:www.davidslog.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updated",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                ),
     *               @OA\Items(
     *                      @OA\Property(
     *                         property="namea",
     *                         type="string",
     *                         example="ahmed"
     *                      ),
     *                      @OA\Property(
     *                         property="followinga",
     *                         type="Boolean",
     *                         example=true
     *                      ),
     *                      @OA\Property(
     *                         property="Urla",
     *                         type="string",
     *                         example="https:www.ahmed_a1.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updateda",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                  ),
     *               ),           
     *           ),
     *        ),
     *     )
     * )
     */
    public function RetrieveQueuedPosts(Request $request, Posts $posts)
    {
        //
    }




    /**
     * @OA\Post(
     ** path="/posts/queue/reorder",
     *   tags={"posts"},
     *   summary="reorder a post within the queue",
     *   operationId="reorder queued posts",
     *  @OA\Parameter(
     *      name="post_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string/integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="insert_after",
     *      description="Which post ID to move it after, or 0 to make it the first post",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string/integer"
     *      )
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
     *      ),
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   )
     *)
     **/
    public function ReorderQueuedPosts(Request $request)
    {
    }


    /**
     * @OA\Post(
     ** path="/posts/queue/shuffle",
     *   tags={"posts"},
     *   summary="shuffle posts within the queue",
     *   operationId="shuffle queued posts",
     * @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *      ),
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   )
     *)
     **/
    public function ShuffleQueuedPosts(Request $request)
    {
    }

    /**
     * @OA\GET(
     * path="/posts/draft",
     * summary="{blog-identifier}/posts/draft",
     * description="user can get the draft posts",
     * operationId="Drafted_posts",
     * tags={"posts"},
     *  @OA\Parameter(
     *         name="before_id",
     *         in="query",
     *         required=false,
     *         description="Return posts that have appeared before this ID",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         required=false,
     *         description="Specifies the post format to return(Html,MarkDown,Rich)",
     *         @OA\Schema(
     *              type="string"
     *         )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="Limit", type="integer",example=10),
     *       @OA\Property(property="filter", type="string", format="string", example="Markdown"),
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
     *    description="sucess",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="Meta", type="object",
     *          @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *       @OA\Property(property="response", type="object",
     *             @OA\Property(property="total_users", type="integer", example=1235),           
     *             @OA\Property(property="Users", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="david"
     *                      ),
     *                      @OA\Property(
     *                         property="following",
     *                         type="Boolean",
     *                         example=true
     *                      ),
     *                      @OA\Property(
     *                         property="Url",
     *                         type="string",
     *                         example="https:www.davidslog.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updated",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                ),
     *               @OA\Items(
     *                      @OA\Property(
     *                         property="namea",
     *                         type="string",
     *                         example="ahmed"
     *                      ),
     *                      @OA\Property(
     *                         property="followinga",
     *                         type="Boolean",
     *                         example=true
     *                      ),
     *                      @OA\Property(
     *                         property="Urla",
     *                         type="string",
     *                         example="https:www.ahmed_a1.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updateda",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                  ),
     *               ),           
     *           ),
     *        ),
     *     )
     * )
     */

    public function RetrieveDraftPosts(Request $request)
    {
        //
    }



        /**
    * @OA\GET(
    * path="/posts/submission",
    * summary="{blog-identifier}/posts/submission",
    * description="retrieve submission posts",
    * operationId="Submission_Posts",
    * tags={"posts"},
    *  @OA\Parameter(
    *         name="offset",
    *         in="query",
    *         required=false,
    *         description="Post number to start at",
    *         @OA\Schema(
    *              type="String"
    *         )
    *      ),
    *  @OA\Parameter(
    *         name="filter",
    *         in="query",
    *         required=false,
    *         description="Specifies the post format to return(Html,MarkDown,Rich)",
    *         @OA\Schema(
    *              type="string"
    *         )
    *      ),
    * @OA\RequestBody(
    *    required=true,
    *    description="Url Example: api.tumblr.com/v1/blog/{blog-identifier}/posts/submission",
    *    @OA\JsonContent(
    *       @OA\Property(property="filter", type="string", format="string", example="Markdown"),
    *    ),
    * ),
    * @OA\Response(
    *    response=404,
    *    description="Not Found",
    *    @OA\JsonContent(
    *       type="object",
    *       @OA\Property(property="Meta", type="object",
    *          @OA\Property(property="Status", type="integer", example=404),
    *           @OA\Property(property="msg", type="string", example="not found"),
    *        ),
    *   ),
    * ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
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
    *             @OA\Property(property="id", type="string/integer",description="The ID of the submitted post",example=12351312),           
    *             @OA\Property(property="post_url", type="string",description="The location of the post",example="https://ahmed-abdelhamed.tumblr.com/post/66686750959666/hajsdfhks"),           
    *             @OA\Property(property="slug", type="string",description="Short text summary to the end of the post URL",example="hajsdfhks"),           
    *             @OA\Property(property="type", type="string",description="The type of post. One of the following: text, photo, quote, link, video",example="text"),           
    *             @OA\Property(property="date", type="string",description="The GMT date and time of the post",example="YYYY-DD-MM HH:MM:SS"),           
    *             @OA\Property(property="timestamp", type="integer",description="The time of the post, in seconds since the epoch",example="1635865720"),           
    *             @OA\Property(property="state", type="string",description="Indicates the current state of the post (submission)",example="submission"),           
    *             @OA\Property(property="format", type="String",description="Format type of post.",example="Html"),           
    *             @OA\Property(property="reblog_key", type="string",description="The reblog key for the post",example="HNvqLd5G"),           
    *             @OA\Property(property="tags", type="array",
    *                @OA\Items(
    *                       example={"winter","summer"}
    *                      ),

    *                   ),
    *            @OA\Property(property="post_author", type="string",description="Author of post, only available when submission is not anonymous",example="ahmed-abdelhamed"),             
    *            @OA\Property(property="is_submission", type="Boolean",description="Indicates post is a submission (true)",example=true),             
    *            @OA\Property(property="is_anonymous", type="Boolean",description="Indicates if the  post is a anonymous",example=false),             
    *            ),
    *        ),
    *     ),
    *  security ={{"bearer":{}}}
    * )
    */
    public function RetrieveSubmissionPosts()
    {

    }

    
    public function Notifications()
    {

    } 


    /**
     * @OA\Delete(
     ** path="/post/delete",
     *   tags={"posts"},
     *   summary="delete existing post",
     *   operationId="destroy",
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="the ID of the post to delete",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="successfully deleted",
     *      @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="Meta", type="object",
     *            @OA\Property(property="Status", type="integer", example=200),
     *            @OA\Property(property="msg", type="string", example="OK"),
     *        ),
     *      ),
     *      
     *    ),
     *)
     **/




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }



    /**
     * @OA\Post(
     ** path="/posts/reblog",
     *   tags={"posts"},
     *   summary="Reblog existing Post",
     *   operationId="reblog",
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="the ID of the reblogged post",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="reblog_key",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="comment",
     *      in="query",
     *      description="comment added to the reblogged post",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="native_inline_images",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=201,
     *          description="Successfully Created",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=201),
     *           @OA\Property(property="msg", type="string", example="Created"),
     *           ),
     *       ),
     *       ),
     *)
     **/

    /**
     * Reblog existing post 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reblog(Request $request)
    {
        //
    }

    /**
     * @OA\GET(
     * path="post/notes",
     * summary="getting notes for specific post",
     * description="This method can be used to get notes for specific post",
     * operationId="getNotes",
     * tags={"posts"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="query",
     *         required=true,
     *      ),
     *   @OA\Parameter(
     *      name="before_timestamp",
     *      in="query",
     *      description="Fetch notes created before this timestamp",
     *      required=false,
     *      @OA\Schema(
     *          type="Number"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="mode",
     *      in="query",
     *      description="The response formatting mode {all , likes , conversation , rollup ,reblogs_with_tags }",
     *      required=false,
     *      @OA\Schema(
     *          type="String"
     *      )
     *   ),
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="id", type="Number", format="text", example="1234567890000"),
     *       @OA\Property(property="before_timestamp", type="Number", format="text", example="1234567890"),
     *       @OA\Property(property="mode", type="string", format="text", example="all"),
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
     *             @OA\Property(property="Users", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="notes",
     *                         type="Array",
     *                      ),
     *                      @OA\Property(
     *                         property="rollup_notes",
     *                         type="Array",
     *                      ),
     *                      @OA\Property(
     *                         property="total_notes",
     *                         type="Number",
     *                         example=125
     *                      ),
     *                      @OA\Property(
     *                         property="total_likes",
     *                         type="Number",
     *                         example=12
     *                      ),
     *                    @OA\Property(
     *                         property="_links",
     *                         type="Object",
     *                         example= "http/...."
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
     * Reblog existing post 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getNotes(Request $request)
    {
        //
    }
}