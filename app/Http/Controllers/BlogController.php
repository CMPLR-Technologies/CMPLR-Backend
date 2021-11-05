<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
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
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
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
     * path="Blog/{blog-identifier}/followed_by",
     * summary="blog/Followed_by",
     * description="This method can be used to check if one of your blogs is followed by another blog",
     * operationId="Followed_by",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="query",
     *         required=true,
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"blog-identifier"},
     *       @OA\Property(property="blog-identifier", type="string", format="text", example="summer_blog"),
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
     *       @OA\Property(property="Status", type="integer", example=200),
     *       @OA\Property(property="msg", type="string", example="OK"),
     *       @OA\Property(property="response", type="string", example="{followed_by : false}")
     *        )
     *     )
     * )
     */
    public function Followed_by(Request $request, Blog $blog)
    {
    }

    /**
     * @OA\Get(
     * path="blog/{blog-identifier}/followers",
     * summary="blog/follows",
     * description="This method can be used to get followers for specific Blog",
     * operationId="followers",
     * tags={"Blogs"},
     *  @OA\Parameter(
     *         name="blog-identifier",
     *         in="query",
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
    public function GetFollower(Request $request, Blog $blog)
    {
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
     *       @OA\Property(property="total_blogs", type="number", example=20),
     *       @OA\Property(property="blogs", type="array",
     *         @OA\Items(
     *           @OA\Property(property="title", type="string", example="John Doe"),
     *           @OA\Property(property="name", type="string", example="john-doe"),
     *           @OA\Property(property="updated", type="number", example=1308953007),
     *           @OA\Property(property="url", type="string", example="https://www.cmplr.com/blogs/john-doe"),
     *           @OA\Property(property="description", type="string", example="<p><strong>Mr. Karp</strong> is tall and skinny, with unflinching blue eyes a mop of brown hair.\r\nHe speaks incredibly fast and in complete paragraphs.</p>"),
     *         )
     *       ),
     *       @OA\Property(property="_links", type="object",
     *         @OA\Property(property="next", type="object",
     *           @OA\Property(property="href", type="string", example="/api/v1/blogs/john-doe/blocks?offset=20"),
     *           @OA\Property(property="method", type="string", example="GET"),
     *           @OA\Property(property="query_params", type="object",
     *             @OA\Property(property="offset", type="number", example=20),
     *           )
     *         )
     *       )
     *     )
     *   )
     * )
     */
    public function getFollowing(Request $request, Blog $blog)
    {
    }
}