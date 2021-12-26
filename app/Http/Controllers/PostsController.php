<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostEditViewResource;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\PostsResource;
use App\Models\Blog;
use App\Models\BlogSettings;
use App\Models\Posts;
use App\Models\User;
use App\Services\Posts\PostsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Posts Controller
    |--------------------------------------------------------------------------|
    | This controller handles the processes of Posts :
    | Create ,edit and update Posts
    | retrieve posts (dashboard , by blogname , post_id)
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
        // set blog_id
        $request['blog_id'] = $blog->id;
        // create the date of the post
        $request['date'] = Carbon::now()->toRfc850String();

        // create post
        $post = $this->PostsService->createPost($request->all());
        if (!$post) {
            $error['post'] = 'error while creating post';
            return $this->error_response(Errors::ERROR_MSGS_500, $error, 500);
        }

        // return post resource
        return $this->success_response(new PostsResource($post), 201);
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
    /**
     * this fuction responsible for edit the specified post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // get the authenticated user
        $user = Auth::user();

        // get the blog_name and post_id
        $blog_name = $request->route('blog_name');
        $post_id = $request->route('post_id');

        // get the blog data by blog_name  
        $blog = $this->PostsService->GetBlogData($blog_name);
        if (!$blog) {
            $error['blog'] = 'there is no blog with this blog_name';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }

        // get the post data by post_id 
        $post = $this->PostsService->GetPostData($post_id);
        if (!$post) {
            $error['post'] = 'there is no post with this id';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }

        // check if this user(blog_name) is authorized to edit this post
        try {
            $this->authorize('EditPost', [$post, $blog]);
        } catch (\Throwable $th) {
            $error['user'] = Errors::AUTHRIZED;
            return $this->error_response(Errors::ERROR_MSGS_401, $error, 401);
        }
        // set up the response        
        return $this->success_response(new PostEditViewResource($post));
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
        // get blog_name and post_id parameters
        $blog_name = $request->route('blog_name');
        $post_id = $request->route('post_id');

        // get the blog data by blog_name  
        $blog = $this->PostsService->GetBlogData($blog_name);
        if (!$blog) {
            $error['blog'] = 'there is no blog with this blog_name';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }

        // get the post data by post_id 
        $post = $this->PostsService->GetPostData($post_id);
        if (!$post) {
            $error['post'] = 'there is no post with this id';
            return $this->error_response(Errors::ERROR_MSGS_404, $error, 404);
        }
        // check if this user(blog_name) is authorized to edit this post
        try {
            $this->authorize('EditPost', [$post, $blog]);
        } catch (\Throwable $th) {
            $error['user'] = Errors::AUTHRIZED;
            return $this->error_response(Errors::ERROR_MSGS_401, $error, 401);
        }
        // update post with all data
        $post->update($request->all());
        return $this->success_response('', 200);
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

    public function GetPostById(Posts $posts, int $post_id)
    {
        $post = Posts::find($post_id);
        if (!$post)
            return $this->error_response(Errors::ERROR_MSGS_404, '', 404);
        // a3mlo post resource bs handle el hta bta3t el auth
        return $this->success_response(new PostsResource($post), 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts, int $post_id)
    {
        // get post from id
        $post = Posts::find($post_id);
        if (!$post)
            return $this->error_response(Errors::ERROR_MSGS_404, '', 404);

        // get blog of this post
        $blog = $post->BLogs;

        // check if this user(blog_name) is authorized to delete this post
        try {
            $this->authorize('delete', [$post, $blog]);
        } catch (\Throwable $th) {
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        }
        // delte post
        $is_deleted = $post->delete();
        if (!$is_deleted){
            $error['post']= 'error while deleting post';
            return $this->error_response(Errors::ERROR_MSGS_500,$error, 500);
        }

        return $this->success_response('', 200);
    }

    /**
     * @OA\get(
     * path="posts/radar/",
     * summary="get email for reset password for  user",
     * description="User can reset password for existing email",
     * operationId="GetResestPassword",
     * tags={"Posts"},
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
     * )
     */

    /**
     * This Function retrieve Post that is not belong to auth user or one of his followers 
     */
    public function GetRadar(Request $request)
    {
        //get auth user
        $user = Auth::user();
        // get random post
        $post =  $this->PostsService->GetRandomPost();
        if(!$post)
            return $this->error_response(Errors::ERROR_MSGS_500,'error get post',500);
        //retrieve post resource
        return $this->success_response(new PostsResource($post), 200);
    }

    /**
     * @OA\get(
     * path="posts/view/{blog_name}",
     * summary="get posts for blog name",
     * description="get the posts by blog_name",
     * operationId="getblogposts",
     * tags={"Posts"},
     *   @OA\Parameter(
     *      name="blog_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
     * )
     */
    public function GetBlogPosts(Request $request, $blog_name)
    {
        //TODO:  retrive only published posts
        $blog = Blog::where('blog_name', $blog_name)->first();
        $posts = Posts::where('blog_id', $blog->id)->orderBy('date', 'DESC')->paginate(Config::PAGINATION_LIMIT);

        // check if user auth or not
        if (auth('api')->check()) {
            $user = auth('api')->user();
            $is_follow = DB::table('user_follow_blog')->where('user_id', $user->id)->get();
        }

        return $this->success_response(new PostsCollection($posts));
    }

    /**
     * This Function Responisble for 
     * get miniview of certain blog by show 3 of its blogs
     * 
     * @param int $blog_id
     * @return response
     */
    public function MiniProfileView(Request $request, int $blog_id)
    {
    
        $blog = Blog::find($blog_id);
        if(!$blog)
            return $this->error_response(Errors::ERROR_MSGS_404,'',404);
        
            // get post data
        $posts = $this->PostsService->MiniViewPostData($blog_id);
        if(!$posts)
            return $this->error_response(Errors::ERROR_MSGS_404,'',404);
        
        // set blog data
        $response['blog'] =  $this->PostsService->MiniViewBlogData($blog);
        
        //get views
        $response['views'] = $this->PostsService->GetViews($posts);
        
        return $this->success_response($response);
    }

    // public function StuffForYou(Request $request)
    // {
    //     $user = auth('api')->user();
    //     $user_followers_id = DB::table('user_follow_blog')->where('user_id',$user->id)->pluck('blog_id');
    //     $blogs_followers = DB::table('user_follow_blog')->whereIn('blog_id',$user_followers_id)->pluck('blog_id');
    //     $posts = Posts::whereIn('blog_id',$blogs_followers)->paginate(5);
    //     return $this->success_response(new PostsCollection($posts));
    // }
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
