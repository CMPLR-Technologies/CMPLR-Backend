<?php

namespace App\Http\Controllers;

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
     *  @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="url",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="privacy",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=false,
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"title","url"},
     *       @OA\Property(property="title", type="string", format="text", example="Summer_Blog"),
     *       @OA\Property(property="url", type="string", format="url", example="example.tumblr.com"),
     *       @OA\Property(property="privacy", type="boolean", example="true"),
     *       @OA\Property(property="password", type="string",format="Password", example="pass123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Created Successfully",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     * @OA\Response(
     *    response=422,
     *    description="Invalid Data",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Blog url is not available!")
     *        )
     *     )
     * )
     */

    //this function creates a new blog and 
    public function create(Request $request)
    {        
        // Auth::attempt(['email' => $request->email, 'password' => $request->pass]);

        $this->validate($request,[
            'title'=>'required',
            'url'=>'required',
            'privacy'=>'required',
            'password'=>'required_if:privacy,true',
        ]);

        $code=(new CreateBlogService())->CreateBlog($request->only('title','url','privacy','password'));
        if($code==422)
            return response()->json(['message'=>'Blog url is not available!'],422);
        else 
            return response()->json(['message'=>'Created Successfully'],201);
    }

    /**
     * @OA\POST(
     * path="/user/follow",
     * summary="Follow a blog",
     * description="enable the user to follow a blog using the blog Email or URL",
     * operationId="UserFollow",
     * tags={"Users"},
     *
     *   @OA\Parameter(
     *      name="url",
     *      description="the url of the blog to follow",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="email",
     *      description="The email of the blog to follow",
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
     *      required={"url","email"},
     *      @OA\Property(property="url", type="string", format="url", example="http://wwww.something.com"),
     *      @OA\Property(property="email", type="string", format="email", example="name@something.com"),
     *      ),
     *    ),
     *
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Blog url is not available!")
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
     *       @OA\Property(property="message", type="string", example="already follwing")
     *        )
     *     ),
     * 
     * )
     */
    public function follow(Request $request)
    {
        $this->validate($request,[
            'url'=>'required'
        ]);

        $blog=Blog::where('url',$request->url)->first();

        $code=(new FollowBlogService())->FollowBlog($blog,auth()->user());
        if($code==409)
            return response()->json(['message'=>'already following'],409);
        else if($code==404)
            return response()->json(['message'=>'Blog url is not available!'],404);
        else    
            return response()->json(['message'=>'success'],200);

    }

    /**
     * @OA\POST(
     * path="/user/unfollow",
     * summary="Unfollow a blog",
     * description="enable the user to Unfollow a blog using the blog URL",
     * operationId="UserUnfollow",
     * tags={"Users"},
     *
     *   @OA\Parameter(
     *      name="url",
     *      description="the url of the blog to unfollow",
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
     *      required={"url"},
     *      @OA\Property(property="url", type="string", format="url", example="http://wwww.something.com"),
     *      ),
     *    ),
     *
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Blog url is not available!")
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
        $this->validate($request,[
            'url'=>'required'
        ]);

        $blog=Blog::where('url',$request->url)->first();

        $code=(new UnfollowBlogService())->UnfollowBlog($blog,auth()->user());
        if($code==409)
            return response()->json(['message'=>'already not following'],409);
        else if($code==404)
            return response()->json(['message'=>'Blog url is not available!'],404);
        else    
            return response()->json(['message'=>'success'],200);

    }


    /**
     * @OA\Delete(
     * path="/blog/{url}",
     * summary="Delete Specific Blog",
     * description="User Delete Specific Blog ",
     * operationId="Delete",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *      ),
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
     *    description="successful",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
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
    public function destroy($url,Request $request)
    {
        // Auth::attempt(['email' => $request->email, 'password' => $request->pass]);

        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $blog=Blog::where('url',$url)->first();
        
        $this->authorize('delete',[$blog,$request]);

        $code=(new DeleteBlogService())->DeleteBlog($blog,auth()->user(),$request->only('email','password'));

        if($code==403)
            return response()->json(['message'=>'email or password is incorrect. Please try again'],403);
        else
            return response()->json(['message'=>'successful'],200);
        
    }
}
