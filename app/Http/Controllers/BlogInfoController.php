<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogInfoController extends Controller
{
    /**
     * @OA\Get(
     *   path="/blog/{blog-identifier}/info",
     *   summary="Retrieve Blog Info",
     *   description="This method returns general information about the blog, such as the title, number of posts, and other high-level data.",
     *   operationId="getBlogInfo",
     *   tags={"Blogs"},
     *   @OA\Parameter(
     *     name="blog-identifier",
     *     in="path",
     *     description="Any blog identifier",
     *     required=true,
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
     *         @OA\Property(property="title", type="string", example="John Doe"),
     *         @OA\Property(property="avatar", type="string", example="https://www.example.com/image/avatar.png"),
     *         @OA\Property(property="posts", type="number", example=69),
     *         @OA\Property(property="name", type="string", example="john-doe"),
     *         @OA\Property(property="url", type="string", example="https://www.cmplr.com/blogs/john-doe"),
     *         @OA\Property(property="updated", type="number", example=1308953007),
     *         @OA\Property(property="description", type="string", example="<p><strong>Mr. Karp</strong> is tall and skinny, with unflinching blue eyes a mop of brown hair.\r\nHe speaks incredibly fast and in complete paragraphs.</p>"),
     *         @OA\Property(property="ask", type="boolean", example=false),
     *         @OA\Property(property="ask_anon", type="boolean", example=false),
     *         @OA\Property(property="likes", type="number", example=420),
     *         @OA\Property(property="is_blocked_from_primary", type="boolean", example=false),
     *         @OA\Property(property="theme", type="object", 
     *           @OA\Property(property="avatar_shape", type="string", example="circle"),
     *           @OA\Property(property="background_color", type="string", example="#00f980"),
     *           @OA\Property(property="body_font", type="string", example="Arial"),
     *           @OA\Property(property="header_image", type="string", example="https://www.example.com/image/header.png"),
     *           @OA\Property(property="link_color", type="string", example="#eefeef"),
     *           @OA\Property(property="show_avatar", type="boolean", example=false),
     *           @OA\Property(property="show_description", type="boolean", example=false),
     *           @OA\Property(property="show_header_image", type="boolean", example=false),
     *           @OA\Property(property="show_title", type="boolean", example=false),
     *           @OA\Property(property="title_color", type="string", example="#f0f0f0"),
     *           @OA\Property(property="title_font", type="string", example="Arial"),
     *           @OA\Property(property="title_font_weight", type="string", example="bold")
     *         )
     *       )
     *     )
     *   )
     * )
     */
    public function getBlogInfo()
    {
        //
    }

    /**
     * @OA\Get(
     *   path="/blog/{blog-identifier}/likes",
     *   summary="Retrieve Blog's Likes",
     *   description="This method can be used to retrieve the publicly exposed likes from a blog.",
     *   operationId="getBlogLikes",
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
     *     description="Block number to start at",
     *     required=false,
     *   ),
     *   @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="The number of blocks to retrieve, 1-20, inclusive",
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
     *         @OA\Property(property="liked_posts", type="array", 
     *           @OA\Items(
     *             @OA\Property(property="blog_name", type="string", example="john-doe"),
     *             @OA\Property(property="blog_url", type="string", example="https://www.cmplr.com/blogs/john-doe"),
     *             @OA\Property(property="post_id", type="number", example="1234567890"),
     *             @OA\Property(property="post_notes_count", type="number", example=20),
     *           ),
     *         ),
     *         @OA\Property(property="liked_count", type="number", example=20),
     *         @OA\Property(property="_links", type="object",
     *           @OA\Property(property="next", type="object",
     *             @OA\Property(property="href", type="string", example="/api/v1/blogs/john-doe/likes?offset=20"),
     *             @OA\Property(property="method", type="string", example="GET"),
     *             @OA\Property(property="query_params", type="object",
     *               @OA\Property(property="offset", type="number", example=20),
     *             )
     *           )
     *         )
     *       )
     *     )
     *   )
     * )
     */
    public function getBlogLikes()
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