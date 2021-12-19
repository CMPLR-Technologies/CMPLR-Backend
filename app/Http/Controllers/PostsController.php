<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\PostsResource;
use App\Models\Blog;
use App\Models\BlogSettings;
use App\Models\BlogUser;
use App\Models\Posts;
use App\Models\User;
use App\Services\Posts\PostsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Post;

class PostsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Posts Controller
    |--------------------------------------------------------------------------|
    | This controller handles the processes of Posts :
    | Create ,update Posts
    |
   */
    protected $PostsService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(PostsService $PostsService)
    {
        $this->PostsService = $PostsService;
    }

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
     *      description ="written in HTML",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *   ),
     * @OA\Parameter(
     *      name="blog_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *   ),
     *  @OA\Parameter(
     *      name="state",
     *      description="the state of the post. Specify one of the following: publish, draft, private",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="String"
     *      ),
     *   ),
     *   @OA\Parameter(
     *      name="tags",
     *      description="array of tags ['tag1','tag2']",
     *      in="query",
     *      required=false,
     *   ),
     *   @OA\Parameter(
     *      name="type",
     *      description="type of post (text,photos,videos,audios,quotes",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="String"
     *      ),
     *   ),
     *    @OA\Parameter(
     *      name="source_content",
     *      description="A source for the post content",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      ),
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"content,blog_name,state,type"},
     *       @OA\Property(property="content", type="string", format="text", example="<h1> hello all</h1><br/> <div><p>my name is <span>Ahmed</span></p></div>"),
     *       @OA\Property(property="blog_name", type="string", format="text", example="Ahmed_1"),
     *       @OA\Property(property="type", type="string", example="text"),
     *       @OA\Property(property="state", type="string", format="text", example="private"),
     *       @OA\Property(property="source_content", type="string", format="text", example="www.geeksforgeeks.com"),
     *       @OA\Property(property="tags", type="string", format="text", example="['DFS','BFS']"),
     * 
     * 
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
     *          response=201,
     *          description="Successfully Created",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=201),
     *           @OA\Property(property="msg", type="string", example="Created"),
     *           ),
     *          @OA\Property(property="response", type="object",
     *              @OA\Property(property="post", type="object",
     *                     @OA\Property(property="id", type="integer", example= 123 ),
     *                     @OA\Property(property="content", type="string", format="text", example="<h1> hello all</h1><br/> <div><p>my name is <span>Ahmed</span></p></div>"),
     *                     @OA\Property(property="type", type="string", example="text"),
     *                     @OA\Property(property="state", type="string", format="text", example="private"),
     *                     @OA\Property(property="source_content", type="string", format="text", example="www.geeksforgeeks.com"),
     *                     @OA\Property(property="tags", type="string", format="text", example="['DFS','BFS']"),
     *                     @OA\Property(property="blog_name", type="string", format="text", example="Ahmed_1"),
     *              ),
     *          ),
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
    public function create(PostRequest $request)
    {
        $user = Auth::user();
        // get the blog from blogname
        $blog = $this->PostsService->GetBlogData($request->blog_name);
        if (!$blog)
            return $this->error_response(Errors::ERROR_MSGS_404, '', 404);

        // check that the user can create post from this Blog
        try {
            $this->authorize('CreatePost', $blog);
        } catch (\Throwable $th) {
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        }

        $request['blog_id'] = $blog->id;
        // create the date of the post
        $request['date'] = Carbon::now()->toRfc850String();

        // create post
        $post = $this->PostsService->createPost($request->all());
        if (!$post) {
            $error['post'] = 'error while creating post';

            return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);

        }
        $response['posts'] = $post;
        return $this->success_response($response, 201);
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
     * @OA\get(
     ** path="/posts/edit/{blog_name}/{post_id}",
     *   tags={"Posts"},
     *   summary="Edit existing Post",
     *   operationId="edit",
     *
     *   @OA\Parameter(
     *      name="post_id",
     *      description="the ID of the post to edit",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="blog_name",
     *      description="the blog_name of the post to edit",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     *          @OA\Property(property="response", type="object",
     *              @OA\Property(property="post", type="object",
     *                     @OA\Property(property="id", type="integer", example= 123 ),
     *                     @OA\Property(property="content", type="string", format="text", example="<h1> hello all</h1><br/> <div><p>my name is <span>Ahmed</span></p></div>"),
     *                     @OA\Property(property="type", type="string", example="text"),
     *                     @OA\Property(property="state", type="string", format="text", example="private"),
     *                     @OA\Property(property="source_content", type="string", format="text", example="www.geeksforgeeks.com"),
     *                     @OA\Property(property="tags", type="string", format="text", example="['DFS','BFS']"),
     *              ),
     *                     @OA\Property(property="blog_name", type="string", format="text", example="Ahmed_1"),
     *                     @OA\Property(property="avatar", type="string", format="text", example="https://assets.tumblr.com/images/default_avatar/cone_closed_128.png"),
     *          ),
     *       ),
     *         
     *          
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
     *      name="content",
     *      description ="written in HTML",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *   ),
     * @OA\Parameter(
     *      name="blog_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *   ),
     *  @OA\Parameter(
     *      name="state",
     *      description="the state of the post. Specify one of the following: publish, draft, private",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="String"
     *      ),
     *   ),
     *   @OA\Parameter(
     *      name="tags",
     *      description="array of tags ['tag1','tag2']",
     *      in="query",
     *      required=false,
     *   ),
     *   @OA\Parameter(
     *      name="type",
     *      description="type of post (text,photos,videos,audios,quotes",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="String"
     *      ),
     *   ),
     *    @OA\Parameter(
     *      name="source_content",
     *      description="A source for the post content",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      ),
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
     *security ={{"bearer":{}}},
     *)
     **/

    public function edit(Request $request)
    {
        $user = Auth::user();

        $blog_name = $request->route('blog_name');
        $post_id = $request->route('post_id');

        $blog = $this->PostsService->GetBlogData($blog_name);
        if (!$blog){
            $error['blog'] = 'there is no blog with this blog_name';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }

        $post = $this->PostsService->GetPostData($post_id);
        if (!$post){
            $error['post'] = 'there is no post with this id';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }


        try {
            $this->authorize('EditPost', [$blog, $post]);
        } catch (\Throwable $th) {
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        }

        $response['avatar'] = BlogSettings::find($blog->id)->first()->avatar;
        $response['blog_name'] = $blog_name;
        $post_data = $post->only(['id', 'type', 'state', 'content', 'date', 'source_content', 'tags']);
        $response['post'] = $post_data;

        return $this->success_response($response);
    }

    /**
     * @OA\PUT(
     ** path="/update/{blog_name}/{post-id}",
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
    public function update(UpdatePostRequest $request)
    {
        $user = Auth::user();
        $blog_name = $request->route('blog_name');
        $post_id = $request->route('post_id');
        
        
        $blog = $this->PostsService->GetBlogData($blog_name);
        if (!$blog){
            $error['blog'] = 'there is no blog with this blog_name';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }

        $post = $this->PostsService->GetPostData($post_id);
        if (!$post){
            $error['post'] = 'there is no post with this id';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }

        $this->authorize('EditPost', [$blog, $post]);
        $post->update($request->all());
        return $this->success_response('');
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
     *     ),
     * security ={{"bearer":{}}}
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
     *   ),
     * security ={{"bearer":{}}}
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
     *   ),
     * security ={{"bearer":{}}}
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
     *     ),
     * security ={{"bearer":{}}}
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
     * @OA\get(
     * path="/radar",
     * summary="get email for reset password for  user",
     * description="User can reset password for existing email",
     * operationId="GetResestPassword",
     * tags={"Auth"},
     *  @OA\Parameter(
     *         name="token",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Successfully",
     *  @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="success"),
     *           ),
     *           @OA\Property(property="response", type="object",
     *              @OA\Property(property="token", type="string", format="text", example="4Y9ZEJqWEABGHkzEXAqNI1F9UZKtKeZVdIChNXBapp9w7XP6mwQZeBXEebMU"),
     *             @OA\Property(property="email", type="string",format="text", example="ahmed.mohamed.abdelhamed2@gmail.com"),
     *           ),
     * ),
     * ),
     *   @OA\Response(
     *      response=404,
     *       description="Not Found",
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="invalid Data",
     *   ),
     * )
     */

    /**
     * This Function retrieve Post that is not belong to auth user or one of his followers 
     */
    public function GetRadar(Request $request)
    {
        $user = Auth::user();
        // $unwanted_blogs = BlogUser::where('user_id', $user->id)->pluck('blog_id');
        // dd($unwanted_blogs);
        
        $post = Posts::where('state','=','publish')->inRandomOrder()->limit(1)->first();
        // $blog = Blog::where('id', $post->blog_id)->first();
        // $avatar = BlogSettings::find($blog->id)->first()->avatar;
        // $response['avatar'] = $avatar;
        // $response['blog_name'] = $blog->blog_name;
        // $response['post'] = $post;
        
        return $this->success_response(new PostsResource($post), 200);
    }

    public function GetBlogPosts(Request $request, $blog_name)
    {
        // $posts =  Posts::join('blogs', 'posts.blog_id', '=', 'blogs.id')
        //     ->join('blog_settings', 'posts.blog_id', '=', 'blog_settings.id')
        //     ->select('posts.*','blogs.id', 'blogs.blog_name', 'blog_settings.avatar','blog_settings.avatar_shape','blog_settings.replies')
        //     ->where('blogs.blog_name', $blog_name)
        //     ->orderBy('date', 'DESC')
        //     ->paginate(Config::API_PAGINATION_LIMIT);
        

        //TODO:  retrive only published posts
        $blog = Blog::where('blog_name',$blog_name)->first();
        $posts = Posts::where('blog_id',$blog->id)->orderBy('date', 'DESC')->paginate(Config::PAGINATION_LIMIT);


        // check if user auth or not
        if (auth('api')->check()) 
        {
            $user = auth()->user();
            $is_follow = DB::table('user_follow_blog')->where('user_id',$user->id)->get();
        }
        
        //new PostsResource($posts->getCollection()) is called inside PostsCollection
        return $this->success_response(new PostsCollection($posts));
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
