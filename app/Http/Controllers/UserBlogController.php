<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Config;
use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Helpers\Success;
use App\Http\Resources\BlogCollection;
use App\Models\Blog;
use App\Services\Blog\CreateBlogService;
use App\Services\Blog\DeleteBlogService;
use App\Services\Blog\FollowBlogService;
use App\Services\Blog\UnfollowBlogService;
use Illuminate\Http\Request;

class UserBlogController extends Controller
{
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
        else
            return $this->success_response('Followed',200);
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
            return $this->success_response('Unfollowed',200);

    }

    public function GetUserFollowing()
    {
        $user = auth('api')->user();
        //TODO: config paginate limit Config::PAGINATION_BLOGS_LIMIT
        
        $blogs = $user->FollowedBlogs()->paginate(15);
        return $this->success_response(new BlogCollection($blogs));
    } 

}
