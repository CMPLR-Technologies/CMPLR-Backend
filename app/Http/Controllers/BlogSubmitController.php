<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogSubmitController extends Controller
{
    /**
     * @OA\Post(
     *   path="/blog/{blog-identifier}/submit",
     *   summary="Submit a Post",
     *   description="Used to submit a post to a blog's inbox",
     *   operationId="submitPost",
     *   tags={"Blogs"},
     *   @OA\Parameter(
     *     name="blog-identifier",
     *     description="Blog name of the person you want to submit a post to",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="Boolean")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       description="Pass user credentials",
     * 	  	  required={"type", "content"},
     *    	  @OA\Property(property="fromBlogName", type="string", format="text", example="abdullah-alshawafi"),
     *    	  @OA\Property(property="fromBlogId", type="integer", format="number", example="230"),
     *    	  @OA\Property(property="tags", type="Boolean", format="boolean", example="true"),
     *    	  @OA\Property(property="type", type="string", format="text", example="Text"),
     *    	  @OA\Property(property="title", type="string", format="text", example="My Post"),
     *    	  @OA\Property(property="content", type="string", format="text", example="how are you?"),
     *     ),
     *   ),
     * 	 @OA\Response(
     *     response=404,
     *     description="Not Found",
     * 	 ),
     * 	 @OA\Response(
     * 	   response=401,
     * 	   description="Unauthenticated"
     * 	 ),
     * 	 @OA\Response(
     * 	   response=200,
     *     description="Success",
     *   ),
     *   security={{"bearer"={}}}
     * )
     */
    public function submitPost()
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
