<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class UserBlogConroller extends Controller
{
    /**
     * @OA\Post(
     * path="/blog",
     * summary="Create new Blog",
     * description="User create new Blog ",
     * operationId="Create",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="Title",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="Url",
     *         in="query",
     *         required=false,
     *      ),
     *  @OA\Parameter(
     *         name="Privacy",
     *         in="query",
     *         required=false,
     *      ),
     *  @OA\Parameter(
     *         name="Password",
     *         in="query",
     *         required=false,
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"Title"},
     *       @OA\Property(property="Title", type="string", format="text", example="Summer_Blog"),
     *       @OA\Property(property="url", type="string", format="url", example="example.tumblr.com"),
     *       @OA\Property(property="Privacy", type="boolean", example="true"),
     *       @OA\Property(property="Password", type="string",format="Password", example="pass123"),
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
    public function follow(Request $request)
    {
        $blog=Blog::where('url',$request->url)->first();
        if($blog->followedBy(auth()->user()))
            return response(null,409);
        $blog->Followers()->create([
            'user_id'=>auth()->id()
        ]);
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
    public function unfollow(Request $request)
    {
        $blog=Blog::where('url',$request->url)->first();
        if(!$blog->FollowedBy(auth()->user()))
            return response(null,409);
        $blog->Followers()->where('user_id',auth()->id())->delete();
    }


    /**
     * @OA\Delete(
     * path="/blog",
     * summary="Delete Specific Blog",
     * description="User Delete Specific Blog ",
     * operationId="Delete",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="Email",
     *         in="query",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="Password",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"Email","Password"},
     *       @OA\Property(property="Email", type="string", format="email", example="Email@gmail.com"),
     *       @OA\Property(property="Password", type="string", format="Password", example="Password123"),
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
     *       @OA\Property(property="msg", type="integer", example=403),
     *       @OA\Property(property="status", type="string", example="That password is incorrect. Please try again")
     *        )
     *     )
     * )
     */
    public function destroy($id)
    {
        //
    }
}
