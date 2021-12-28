<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Misc\Helpers\Errors;
use App\Services\Blog\BlogService;
use App\Http\Resources\BlogCollection;
use App\Services\Blog\FollowBlogService;

class BlogController extends Controller
{


    protected $BlogService;
    protected $FollowBlogService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(FollowBlogService $FollowBlogService, BlogService $BlogService)
    {
        $this->BlogService = $BlogService;
        $this->FollowBlogService = $FollowBlogService;
    }

    /**
     * This function is responsible for getting
     * recommended blogs (paginated)
     * 
     * @return Blog $recommended_blogs
     */
    public function GetRecommendedBlogs()
    {
        $recommended_blogs = $this->BlogService->GetRandomBlogs();

        if (!$recommended_blogs) {
            return $this->error_response(Errors::ERROR_MSGS_404, '', 404);
        }

        $response = $this->success_response(new BlogCollection($recommended_blogs));

        return $response;
    }

    /**
     * This function is responsible for getting
     * trending blogs (paginated)
     * 
     * @return Blog $trending_blogs
     */
    public function GetTrendingBlogs()
    {
        $trending_blogs = $this->BlogService->GetRandomBlogs();

        if (!$trending_blogs) {
            return $this->error_response(Errors::ERROR_MSGS_404, '', 404);
        }

        $response = $this->success_response(new BlogCollection($trending_blogs));

        return $response;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Blog $blog)
    {
        //
    }



    /**
     * @OA\Get(
     * path="/blog/{blog-identifier}/followed_by",
     * summary="Check If Followed By Blog",
     * description="This method can be used to check if one of your blogs is followed by another blog.",
     * operationId="followedBy",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="path",
     *         required=true,
     *      ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     * ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated",
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       ),
     *       @OA\Property(property="response", type="object",
     *         @OA\Property(property="followed_by", type="boolean", example=false),
     *       )
     *    )
     * ),
     * security ={{"bearer":{}}}
     * )
     */
    public function followedBy(Request $request, Blog $blog)
    {
    }

    /**
     * @OA\Get(
     * path="/blog/{blog-identifier}/followers",
     * summary="Retrieve a Blog's Followers",
     * description="This method can be used to get the followers of a specific blog",
     * operationId="getFollowers",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="path",
     *         required=true,
     *      ),
     *  @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         description="The number of results to return: 1–20",
     *      ),
     *  @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         required=false,
     *         description="Result to start at",
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"blog-identifier"},
     *       @OA\Property(property="blog-identifier", type="string", format="text", example="summer_blog"),
     *       @OA\Property(property="limit", type="integer", format="integer", example= 10),
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
     *    description="Success",
     *    @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="meta", type="object",
     *          @OA\Property(property="status", type="integer", example=200),
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
     *                         property="url",
     *                         type="string",
     *                         example="https://www.davidslog.com"
     *                      ),
     *                      @OA\Property(
     *                         property="updated",
     *                         type="integer",
     *                         example=1308781073
     *                      ),
     *                ),
     *             ),           
     *           ),
     *        ),
     *     ),
     * security ={{"bearer":{}}}
     * )
     */
    /**
     * Get Blog Followers
     * 
     * @param 
     * 
     */
    public function GetFollowers(Request $request, Blog $blog)
    {
        // get blog_name
        $blog_name = $request->route('blog_name');
        // Get Blog using blog_name

        $blog = $this->FollowBlogService->GetBlog($blog_name);
        if (!$blog)
            return $this->error_response(Errors::ERROR_MSGS_404, 'Blog Not Found ', 404);

        // Check if This USer is Authorize to do this action
        try {
            $this->authorize('ViewFollowers', $blog);
        } catch (\Throwable $th) {
            return $this->error_response(Errors::ERROR_MSGS_403, 'This action is unauthorized.', 403);
        }
        // Get followers'sid that follow this blog
        $followers_id = $this->FollowBlogService->GetFollowersID($blog->id);

        // Get Followers Information
        $followers_info = $this->FollowBlogService->GetFollowersInfo($followers_id);

        $response['number_of_followers'] = count($followers_id);
        $response['followers'] = $followers_info;

        return $this->success_response($response);
    }

    /**
     * @OA\Get(
     *   path="/blog/{blog-identifier}/following",
     *   summary="Retrieve Blog's following",
     *   description="This method can be used to retrieve the publicly exposed list of blogs that a blog follows, in order from most recently-followed to first.",
     *   operationId="getFollowing",
     *   tags={"Blogs"},
     *   @OA\Parameter(
     *     name="blog-identifier",
     *     in="path",
     *     description="Any blog identifier",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     description="Followed blog index to start at",
     *     required=false,
     *   ),
     *   @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="The number of results to retrieve, 1-20, inclusive",
     *     required=false,
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       ),
     *       @OA\Property(property="response", type="object",
     *         @OA\Property(property="total_blogs", type="number", example=20),
     *         @OA\Property(property="blogs", type="array",
     *           @OA\Items(
     *             @OA\Property(property="title", type="string", example="John Doe"),
     *             @OA\Property(property="name", type="string", example="john-doe"),
     *             @OA\Property(property="updated", type="number", example=1308953007),
     *             @OA\Property(property="url", type="string", example="https://www.cmplr.com/blogs/john-doe"),
     *             @OA\Property(property="description", type="string", example="<p><strong>Mr. Karp</strong> is tall and skinny, with unflinching blue eyes a mop of brown hair.\r\nHe speaks incredibly fast and in complete paragraphs.</p>"),
     *           )
     *         ),
     *         @OA\Property(property="_links", type="object",
     *           @OA\Property(property="next", type="object",
     *             @OA\Property(property="href", type="string", example="/api/v1/blogs/john-doe/blocks?offset=20"),
     *             @OA\Property(property="method", type="string", example="GET"),
     *             @OA\Property(property="query_params", type="object",
     *               @OA\Property(property="offset", type="number", example=20),
     *             )
     *           )
     *         )
     *       )
     *     )
     *   ),
     * security ={{"bearer":{}}}
     * )
     */
    public function getFollowing(Request $request, Blog $blog)
    {
    }
}