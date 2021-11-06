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
     *   tags={"Posts"},
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
     *   tags={"Posts"},
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
     *   tags={"Posts"},
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
     *   tags={"Posts"},
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
     * tags={"Posts"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         description="The type of post to return one of the following: text, quote, link, answer, video, audio, photo, chat",
     * ),
     *  @OA\Parameter(
     *         name="post_id",
     *         in="query",
     *         required=false,
     *         description="A specific post ID",
     *         @OA\Schema(
     *              type="integer"
     *         )
     *      ),
     *  @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         required=false,
     *         description="Limits the response to posts with the specified tag(s), see note below",
     *         @OA\Schema(
     *              type="string"
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
     *    @OA\JsonContent(
     *       required={"blog-identifier","api_key"},
     *       @OA\Property(property="blog-identifier", type="string", format="text", example="summer_blog"),
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
     *             @OA\Property(property="total_no_posts", type="integer", example=2),           
     *             @OA\Property(property="posts", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="post_state",
     *                         type="string",
     *                         example="published"
     *                      ),
     *                      @OA\Property(
     *                         property="post_id",
     *                         type="integer",
     *                         example=13212313
     *                      ),
     *                      @OA\Property(
     *                         property="blog_id",
     *                         type="integer",
     *                         example=123153
     *                      ),
     *                      @OA\Property(
     *                         property="blog_name",
     *                         type="string",
     *                         example="summer"
     *                      ),
     *                      @OA\Property(
     *                         property="post_type",
     *                         type="string",
     *                         example="text"
     *                      ),
     *            @OA\Property(
     *                property="content",
     *                type="array",
     *                example={{
     *                  "type": "text",
     *                  "title":"hello",
     *                  "text": "i am very tired of this",
     *                }, {
     *                  "type": "image",
     *                  "image_url": "http://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90",
     *                  "caption": "my image in cmp",
     *                  "alt_text": "photo about friend taking a photo in university"
     *                },{
     *                  "type": "link",
     *                  "url": "https://www.youtube.com/watch?v=yn6ehJS9vv4",
     *                  "title": "Secrecy Surrounding Senate Health Bill Raises Alarms in Both Parties",
     *                  "description":"Senate leaders are writing legislation to repeal and replace the Affordable Care Act without a single hearing on the bill and without an open drafting session.",
     *                  "site_name":"youtube"
     *                },{
     *                  "type": "audio",
     *                  "url": "https://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90/tumblr_nshp8oVOnV1rg0s9xo1.mp3",
     *                  "provider": "soundcloud",
     *                  "title":"believer",
     *                  "artist(optional)":"imagine dragon",
     *                  "album(optional)":"evolve",
     *                  "description":"Senate leaders are writing legislation to repeal and replace the Affordable Care Act without a single hearing on the bill and without an open drafting session.",
     *                  "site_name":"youtube"
     *                },{
     *                  "type": "video",
     *                  "url": "http://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90",
     *                  "provider":"youtube"
     *                }
     * },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *                      @OA\Property(
     *                         property="reblog_key",
     *                         type="integer",
     *                         example=12553
     *                      ),
     *                      @OA\Property(
     *                         property="limit",
     *                         type="integer",
     *                         example=5
     *                      ),
     *                      @OA\Property(
     *                         property="parent_blog_id",
     *                         type="integer",
     *                         example=12523
     *                      ),
     *                      @OA\Property(
     *                         property="parent_post_id",
     *                         type="integer",
     *                         example=1223
     *                      ),
     *                      @OA\Property(
     *                         property="post_timestamp",
     *                         type="integer",
     *                         example="15311351351"
     *                      ),
     *                      @OA\Property(
     *                         property="post_date",
     *                         type="string",
     *                         example="01:01:11"
     *                      ),
     *                      @OA\Property(
     *                         property="format",
     *                         type="string",
     *                         example="Rich text"
     *                      ),
     *                      @OA\Property(
     *                         property="blog_avatar",
     *                         type="string",
     *                         example="http://media.tumblr.com/avatar/b06fe71cc4ab"
     *                      ),
     *                      @OA\Property(
     *                         property="number_notes",
     *                         type="integer",
     *                         example=25
     *                      ),
     *            @OA\Property(
     *                property="layout",
     *                type="array",
     *                example={{
     *                  "type": "rows",
     *                  "display": "[{blocks:[0,1]} , {blocks:[2]}]",
     *                }
     *              },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *            @OA\Property(
     *                property="tags",
     *                type="array",
     *                example={{
     *                     "summer","winter"
     *                }
     *              },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
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
     * tags={"Posts"},
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
     *             @OA\Property(property="total_no_posts", type="integer", example=2),           
     *             @OA\Property(property="posts", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="post_state",
     *                         type="string",
     *                         example="published"
     *                      ),
     *                      @OA\Property(
     *                         property="post_id",
     *                         type="integer",
     *                         example=13212313
     *                      ),
     *                      @OA\Property(
     *                         property="blog_id",
     *                         type="integer",
     *                         example=123153
     *                      ),
     *                      @OA\Property(
     *                         property="blog_name",
     *                         type="string",
     *                         example="summer"
     *                      ),
     *                      @OA\Property(
     *                         property="post_type",
     *                         type="string",
     *                         example="text"
     *                      ),
     *            @OA\Property(
     *                property="content",
     *                type="array",
     *                example={{
     *                  "type": "text",
     *                  "title":"hello",
     *                  "text": "i am very tired of this",
     *                }, {
     *                  "type": "image",
     *                  "image_url": "http://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90",
     *                  "caption": "my image in cmp",
     *                  "alt_text": "photo about friend taking a photo in university"
     *                },{
     *                  "type": "link",
     *                  "url": "https://www.youtube.com/watch?v=yn6ehJS9vv4",
     *                  "title": "Secrecy Surrounding Senate Health Bill Raises Alarms in Both Parties",
     *                  "description":"Senate leaders are writing legislation to repeal and replace the Affordable Care Act without a single hearing on the bill and without an open drafting session.",
     *                  "site_name":"youtube"
     *                },{
     *                  "type": "audio",
     *                  "url": "https://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90/tumblr_nshp8oVOnV1rg0s9xo1.mp3",
     *                  "provider": "soundcloud",
     *                  "title":"believer",
     *                  "artist(optional)":"imagine dragon",
     *                  "album(optional)":"evolve",
     *                  "description":"Senate leaders are writing legislation to repeal and replace the Affordable Care Act without a single hearing on the bill and without an open drafting session.",
     *                  "site_name":"youtube"
     *                },{
     *                  "type": "video",
     *                  "url": "http://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90",
     *                  "provider":"youtube"
     *                }
     * },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *                      @OA\Property(
     *                         property="reblog_key",
     *                         type="integer",
     *                         example=12553
     *                      ),
     *                      @OA\Property(
     *                         property="limit",
     *                         type="integer",
     *                         example=5
     *                      ),
     *                      @OA\Property(
     *                         property="order_in_queue",
     *                         type="integer",
     *                         example=2
     *                      ),
     *                      @OA\Property(
     *                         property="parent_blog_id",
     *                         type="integer",
     *                         example=12523
     *                      ),
     *                      @OA\Property(
     *                         property="parent_post_id",
     *                         type="integer",
     *                         example=1223
     *                      ),
     *                      @OA\Property(
     *                         property="post_timestamp",
     *                         type="integer",
     *                         example="15311351351"
     *                      ),
     *                      @OA\Property(
     *                         property="post_date",
     *                         type="string",
     *                         example="01:01:11"
     *                      ),
     *                      @OA\Property(
     *                         property="format",
     *                         type="string",
     *                         example="Rich text"
     *                      ),
     *                      @OA\Property(
     *                         property="blog_avatar",
     *                         type="string",
     *                         example="http://media.tumblr.com/avatar/b06fe71cc4ab"
     *                      ),
     *                      @OA\Property(
     *                         property="number_notes",
     *                         type="integer",
     *                         example=25
     *                      ),
     *            @OA\Property(
     *                property="layout",
     *                type="array",
     *                example={{
     *                  "type": "rows",
     *                  "display": "[{blocks:[0,1]} , {blocks:[2]}]",
     *                }
     *              },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *            @OA\Property(
     *                property="tags",
     *                type="array",
     *                example={{
     *                     "summer","winter"
     *                }
     *              },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
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
     *   tags={"Posts"},
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
     *   tags={"Posts"},
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
     * tags={"Posts"},
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
     * tags={"Posts"},
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
     *   @OA\Response(
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
     *             @OA\Property(property="total_no_posts", type="integer", example=2),           
     *             @OA\Property(property="posts", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="post_state",
     *                         type="string",
     *                         example="published"
     *                      ),
     *                      @OA\Property(
     *                         property="post_id",
     *                         type="integer",
     *                         example=13212313
     *                      ),
     *                      @OA\Property(
     *                         property="blog_id",
     *                         type="integer",
     *                         example=123153
     *                      ),
     *                      @OA\Property(
     *                         property="blog_name",
     *                         type="string",
     *                         example="summer"
     *                      ),
     *                      @OA\Property(
     *                         property="post_type",
     *                         type="string",
     *                         example="text"
     *                      ),
     *            @OA\Property(
     *                property="content",
     *                type="array",
     *                example={{
     *                  "type": "text",
     *                  "title":"hello",
     *                  "text": "i am very tired of this",
     *                }, {
     *                  "type": "image",
     *                  "image_url": "http://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90",
     *                  "caption": "my image in cmp",
     *                  "alt_text": "photo about friend taking a photo in university"
     *                },{
     *                  "type": "link",
     *                  "url": "https://www.youtube.com/watch?v=yn6ehJS9vv4",
     *                  "title": "Secrecy Surrounding Senate Health Bill Raises Alarms in Both Parties",
     *                  "description":"Senate leaders are writing legislation to repeal and replace the Affordable Care Act without a single hearing on the bill and without an open drafting session.",
     *                  "site_name":"youtube"
     *                },{
     *                  "type": "audio",
     *                  "url": "https://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90/tumblr_nshp8oVOnV1rg0s9xo1.mp3",
     *                  "provider": "soundcloud",
     *                  "title":"believer",
     *                  "artist(optional)":"imagine dragon",
     *                  "album(optional)":"evolve",
     *                  "description":"Senate leaders are writing legislation to repeal and replace the Affordable Care Act without a single hearing on the bill and without an open drafting session.",
     *                  "site_name":"youtube"
     *                },{
     *                  "type": "video",
     *                  "url": "http://media.tumblr.com/b06fe71cc4ab47e93749df060ff54a90",
     *                  "provider":"youtube"
     *                }
     * },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *                      @OA\Property(
     *                         property="reblog_key",
     *                         type="integer",
     *                         example=12553
     *                      ),
     *                      @OA\Property(
     *                         property="limit",
     *                         type="integer",
     *                         example=5
     *                      ),
     *                      @OA\Property(
     *                         property="parent_blog_id",
     *                         type="integer",
     *                         example=12523
     *                      ),
     *                      @OA\Property(
     *                         property="parent_post_id",
     *                         type="integer",
     *                         example=1223
     *                      ),
     *                      @OA\Property(
     *                         property="post_timestamp",
     *                         type="integer",
     *                         example="15311351351"
     *                      ),
     *                      @OA\Property(
     *                         property="post_date",
     *                         type="string",
     *                         example="01:01:11"
     *                      ),
     *                      @OA\Property(
     *                         property="format",
     *                         type="string",
     *                         example="Rich text"
     *                      ),
     *                      @OA\Property(
     *                         property="blog_avatar",
     *                         type="string",
     *                         example="http://media.tumblr.com/avatar/b06fe71cc4ab"
     *                      ),
     *                      @OA\Property(
     *                         property="number_notes",
     *                         type="integer",
     *                         example=25
     *                      ),
     *            @OA\Property(
     *                property="layout",
     *                type="array",
     *                example={{
     *                  "type": "rows",
     *                  "display": "[{blocks:[0,1]} , {blocks:[2]}]",
     *                }
     *              },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *            @OA\Property(
     *                property="tags",
     *                type="array",
     *                example={{
     *                     "summer","winter"
     *                }
     *              },
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="firstName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="lastName",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="companyId",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="accountNumber",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="netPay",
     *                         type="money",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *                  ),
     *               ),

     *           ),
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
     *   tags={"Posts"},
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
     *  security ={{"bearer":{}}}
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
     *   tags={"Posts"},
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
     * security ={{"bearer":{}}}
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
     * path="/post/notes",
     * summary="getting notes for specific post",
     * description="This method can be used to get notes for specific post",
     * operationId="getNotes",
     * tags={"Posts"},
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

        /**
    *	@OA\Get
    *	(
    * 		path="/tagged",
    * 		summary="Get Posts with Tag",
    * 		description="retrieve the posts with specific tag",
    * 		operationId="getTaggedPosts",
    * 		tags={"Posts"},
    *
    *    	@OA\Parameter
    *		(
    *      		name="tag",
    *      		description="The tag on the posts you'd like to retrieve",
    *      		in="path",
    *      		required=true,
    *      		@OA\Schema
    *			(
    *           		type="String"
    *      		)
    *   	),
    *
    *    	@OA\Parameter
    *		(
    *			name="before",
    *			description="The timestamp of when you'd like to see posts before.",
    *			in="query",
    *			required=false,
    *		    @OA\Schema
    *		 	(
    *		           type="integer"
    *			)
    *   	),
    *
    *   	@OA\Parameter
    *		(
    *      		name="limit",
    *      		description="the number of posts to return",
    *      		in="query",
    *      		required=false,
    *      		@OA\Schema
    *			(
    *           		type="Number"
    *      		)
    *   	),
    *
    *    	@OA\Parameter
    *		(
    *			name="filter",
    *			description="Specifies the post format to return, other than HTML: text – Plain text, no HTML; raw – As entered by the user (no post-processing)",
    *			in="query",
    *			required=false,
    *		    @OA\Schema
    *		 	(
    *		           type="String"
    *			)
    *   	),
    *    
    *    	@OA\RequestBody
    *		(
    *      		required=true,
    *      		description="Pass user credentials",
    *      		@OA\JsonContent
    *			(
    *	    		required={"tag"},
    *      			@OA\Property(property="tag", type="String", format="text", example="anime"),
    *      			@OA\Property(property="before", type="integer", format="integer", example=10),
    *      			@OA\Property(property="limit", type="integer", format="integer", example=1),
    *      			@OA\Property(property="filter", type="String", format="text", example="HTML"),
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
    *             			@OA\Property(property="blog", type="object"),
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
    *					    @OA\Property(property="total_posts", type="integer", example=3),
    *           		),
    *        		),
    *     	)
    * )
    */
    public function getTaggedPosts()
    {

    }

}