<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Helpers\Success;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Services\Blog\CreateBlogService;
use App\Services\Blog\DeleteBlogService;
use App\Services\Blog\FollowBlogService;
use App\Services\Blog\UnfollowBlogService;
use App\Services\Notifications\NotificationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserBlogController extends Controller
{

    /*
     | This Controller responsible for handling 
     | the function linking users and blogs
     |
     */

    /**
     * @OA\Post(
     * path="/blog",
     * summary="Create new Blog",
     * description="User create new Blog ",
     * operationId="Create",
     * tags={"Blogs"},
     * 
     *  @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=true,
     *      ),
     * 
     *  @OA\Parameter(
     *         name="blogName",
     *         in="query",
     *         required=true,
     *      ),
     * 
     *  @OA\Parameter(
     *         name="privacy",
     *         in="query",
     *         required=true,
     *      ),
     * 
     *  @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=false,
     *      ),
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"title","blogName"},
     *       @OA\Property(property="title", type="string", format="text", example="Summer_Blog"),
     *       @OA\Property(property="blogName", type="string", format="blogName", example="example.tumblr.com"),
     *       @OA\Property(property="privacy", type="boolean", example="true"),
     *       @OA\Property(property="password", type="string",format="Password", example="pass123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Created Successfully",
     * ),
     * 
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * 
     * @OA\Response(
     *    response=422,
     *    description="Invalid Data",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Blog name is not available!")
     *        )
     *     )
     * )
     */

    
    //this function creates a new blog
    public function create(Request $request)
    {

        //validate the request parameters
        $this->validate($request, [
            'title' => 'required',
            'blogName' => 'required',
            'privacy' => 'required',
            'password' => 'required_if:privacy,true',
        ]);

        //calling the service , responsible for creating a blog
        $code = (new CreateBlogService())->CreateBlog($request->only('title', 'blogName', 'privacy', 'password'), auth()->user());

        //response with the appropriate response 
        if ($code == 422)
            return $this->error_response(Errors::ERROR_MSGS_422,'Blog name is not available!',422);
        else
            return $this->success_response('Created Successfully',201);

    }

        /**
     * @OA\Post(
     * path="/blog/{blogName}",
     * summary="Delete Specific Blog",
     * description="User Delete Specific Blog, note this is a post request cause you need to send your password",
     * operationId="Delete",
     * tags={"Blogs"},
     * 
     *  @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *      ),
     * 
     *  @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *      ),
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="Email@gmail.com"),
     *       @OA\Property(property="password", type="string", format="Password", example="Password123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="deleted",
     * ),
     * 
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * 
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=403),
     *       @OA\Property(property="message", type="string", example="email or password is incorrect. Please try again")
     *        )
     *     )
     * )
     */

    //this method deletes a specific blog 
    public function destroy($blogName, Request $request)
    {
        //validate the request parameters
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //getting the blog
        $blog = Blog::where('blog_name', $blogName)->first();

        if($blog==null)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);

        //checking if this authorized through policy
        $this->authorize('delete', $blog);
     
        //calling the service , responsible for deleting a blog        
        $code = (new DeleteBlogService())->DeleteBlog($blog, auth()->user(), $request->only('email', 'password'));

        //response with the appropriate response 
        if ($code == 403)
            return $this->error_response(Errors::ERROR_MSGS_403,'email or password is incorrect. Please try again',403);
        else
            return $this->success_response('deleted',200);
    }


    /**
     * @OA\POST(
     * path="/user/follow",
     * summary="Follow a blog",
     * description="enable the user to follow a blog using the blogName",
     * operationId="UserFollow",
     * tags={"Users"},
     *
     *   @OA\Parameter(
     *      name="blogName",
     *      description="the blogName of the blog to follow",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *    
     *    @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *      @OA\Property(property="blogName", type="string", format="text", example="myblog"),
     *      ),
     *    ),
     *
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Blog name is not available!")
     *        )
     * ),
     * 
     * @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * 
     *   @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="success")
     *        )
     *     ),
     * 
     *    @OA\Response(
     *    response=409,
     *    description="conflict",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="already follwing")
     *        )
     *     ),
     * 
     * )
     */

    public function follow(Request $request)
    {
        //validate the request parameters
        $this->validate($request, [
            'blogName' => 'required'
        ]);

        //get the blog to follow
        $blog = Blog::where('blog_name', $request->blogName)->first();

        //calling the service , responsible for deleting a blog        
        $code = (new FollowBlogService())->FollowBlog($blog, auth()->user());

        //response with the appropriate response        
        if ($code == 409)
            return $this->error_response(Errors::ERROR_MSGS_409,'Already following',409);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else if($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'target blog is blocked',403);
        else
        {
            //add follow notification
            (new NotificationsService())->CreateNotification(
                auth()->user()->primary_blog_id,
                $blog->id,
                'follow',
                null,
            );

            return $this->success_response('Followed',200);
        }

    }



    /**
     * @OA\Delete(
     * path="/user/follow",
     * summary="Unfollow a blog",
     * description="enable the user to Unfollow a blog using the blog name",
     * operationId="UserUnfollow",
     * tags={"Users"},
     *
     *   @OA\Parameter(
     *      name="blogName",
     *      description="the name of the blog to unfollow",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *    
     *    @OA\RequestBody(
     *      required=true,
     *      description="Pass user credentials",
     *      @OA\JsonContent(
     *      required={"blogName"},
     *      @OA\Property(property="blogName", type="string", format="blogName", example="myblog"),
     *      ),
     *    ),
     *
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Blog name is not available!")
     *        )
     * ),
     * @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="success")
     *        )
     *     ),
     * @OA\Response(
     *    response=409,
     *    description="conflict",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="already not follwing")
     *        )
     *     ),
     * )
     */
    public function unfollow(Request $request)
    {
        //validate the request parameters
        $this->validate($request, [
            'blogName' => 'required'
        ]);

        //get the blog to follow
        $blog = Blog::where('blog_name', $request->blogName)->first();

        //calling the service , responsible for deleting a blog        
        $code = (new UnfollowBlogService())->UnfollowBlog($blog, auth()->user());

        //response with the appropriate response 
        if ($code == 409)
            return $this->error_response(Errors::ERROR_MSGS_409,'Already not following',409);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else
        {
            //remove follow notification
            (new NotificationsService())->DeleteNotification(
                auth()->user()->primary_blog_id,
                $blog->id,
                'follow',
                null,
                null
            );

            return $this->success_response('Unfollowed',200);
        }
    }

     /**
     *	@OA\Get
     *	(
     * 		path="user/following",
     * 		summary="User setting",
     * 		description="Retrieve following blogs for User.",
     * 		operationId="Retrieve followings",
     * 		tags={"User"},
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
     *          @OA\Property(property="blogs", type="array",
     *            @OA\Items(
     *              @OA\Property(property="post", type="object",
     *                     @OA\Property(property="blog_id", type="integer", example= 123 ),
     *                     @OA\Property(property="blog_name", type="string", example="ahmed"),
     *                     @OA\Property(property="title", type="string", format="text", example="CMP"),
     *                     @OA\Property(property="avatar", type="string", format="text", example="https://assets.tumblr.com/images/default_avatar/cone_closed_128.png"),
     *                     @OA\Property(property="avatar_shape", type="string", format="text", example="Circle"),
     *                     @OA\Property(property="description", type="string", format="text", example="ahmed217"),
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
    /**
     * This function is responsible for get the blogs that user follows
     * @param 
     * @return response
     */
    public function GetUserFollowing()
    {
        //get auth user
        $user = auth('api')->user();
        // get blogs id that authenticated user follows
        $blog_ids =(new FollowBlogService())->GetBlogIds($user->id);
        //get needed info about these blogs
        $blogs = Blog::whereIn('id',$blog_ids)->paginate(Config::PAGINATION_BLOGS_LIMIT);
        return $this->success_response(new BlogCollection($blogs));
    } 


    public function GetBlogInfo($blogId)
    {
        $blog=Blog::find($blogId);
        return $this->success_response(new BlogResource($blog),200);
    }

}
