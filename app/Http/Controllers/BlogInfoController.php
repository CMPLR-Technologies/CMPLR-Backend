<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogInfoController extends Controller
{
    /**
     * @OA\GET(
     *   path="/blog/{blog-identifier}/info",
     *   summary="Retrieve Blog Info",
     *   description="This method returns general information about the blog, such as the title, number of posts, and other high-level data.",
     *   operationId="getBlogInfo",
     *   tags={"Blogs"},
     *   @OA\Parameter(
     *     name="blog-identifier",
     *     in="query",
     *     description="Any blog identifier",
     *     required=true,
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="title", type="string", example="John Doe"),
     *       @OA\Property(property="posts", type="number", example=69),
     *       @OA\Property(property="name", type="string", example="john-doe"),
     *       @OA\Property(property="updated", type="number", example=1308953007),
     *       @OA\Property(property="description", type="string", example="<p><strong>Mr. Karp</strong> is tall and skinny, with unflinching blue eyes a mop of brown hair.\r\nHe speaks incredibly fast and in complete paragraphs.</p>"),
     *       @OA\Property(property="likes", type="number", example=420),
     *       @OA\Property(property="is_blocked_from_primary", type="boolean", example=false),
     *       @OA\Property(property="theme", type="object", 
     *         @OA\Property(property="avatar_shape", type="string", example="circle"),
     *         @OA\Property(property="background_color", type="string", example="#00f980"),
     *         @OA\Property(property="body_font", type="string", example="Arial"),
     *         @OA\Property(property="header_image", type="string", example="example.com/image/header.png"),
     *         @OA\Property(property="link_color", type="string", example="#eefeef"),
     *         @OA\Property(property="show_avatar", type="boolean", example=false),
     *         @OA\Property(property="show_description", type="boolean", example=false),
     *         @OA\Property(property="show_header_image", type="boolean", example=false),
     *         @OA\Property(property="show_title", type="boolean", example=false),
     *         @OA\Property(property="title_color", type="string", example="#f0f0f0"),
     *         @OA\Property(property="title_font", type="string", example="Arial"),
     *         @OA\Property(property="title_font_weight", type="string", example="bold")
     *       )
     *     )
     *   )
     * )
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}