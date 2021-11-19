<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        Auth::attempt(['email' => $request->email, 'password' => $request->pass]);

        $this->validate($request,[
            'title'=>'required',
            'url'=>'required',
            'privacy'=>'required',
            'password'=>'required_if:privacy,true',
        ]);

        $primary=false;
        if(auth()->user()->Blogs->isEmpty())
            $primary=true;

        
        $blog=Blog::create([
            'title'=>$request->title,
            'url'=>$request->url,
            'privacy'=>$request->privacy,
            'password'=>$request->password,
        ]);

        $blog->Users()->create([
            'user_id'=>auth()->id(),
            'primary'=>$primary,
            'full_privileges'=>'true',
            'contributor_privileges'=>'false'
        ]);

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
     *       @OA\Property(property="msg", type="integer", example=403),
     *       @OA\Property(property="status", type="string", example="That password is incorrect. Please try again")
     *        )
     *     )
     * )
     */

    //this method deletes a specific blog 
    public function destroy($url,Request $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->pass]);

        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);


        $blog=Blog::where('url',$url)->first();
        
        $this->authorize('delete',[$blog,$request]);
        
        $pUser=User::find($blog->Users->where('primary',true)->first()->user_id);
        if($pUser!=null)
        {
            $pBlogsId=$pUser->Blogs()->get('blog_id')->pluck('blog_id')->toArray();
            $pUser->delete();
            $pBlogs=Blog::all()->whereIn('id',$pBlogsId);
            foreach($pBlogs as $pblog)
            {
                if($pblog->Users->isEmpty())
                    $pblog->delete();
            }
        }
        $blog->delete();
    }
}