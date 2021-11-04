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
     * @OA\POST(
     * path="Blog/",
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
     * @OA\GET(
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
     * @OA\GET(
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\DELETE(
     * path="Blog/",
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
     *    response=422,
     *    description="Invalid Data",
     *    @OA\JsonContent(
     *       @OA\Property(property="msg", type="integer", example=422),
     *       @OA\Property(property="status", type="string", example="That password is incorrect. Please try again")
     *        )
     *     )
     * )
     */
    public function destroy(Blog $blog)
    {
        //
    }
}