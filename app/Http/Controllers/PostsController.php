<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
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
     * @OA\Post(
     ** path="/posts",
     *   tags={"posts"},
     *   summary="create new post",
     *   operationId="create",
     *  @OA\Parameter(
     *      name="content",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Array"
     *      )
     *   ),
     * *  @OA\Parameter(
     *      name="layout",
     *      description="there are different types of layout for posts",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Array"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="state",
     *      description="the state of the post. Specify one of the following: published, draft, queue, private",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="publish_on",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="tags",
     *      description="Comma-separated tags for this post",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="date",
     *      description="The GMT date and time of the post, as a string",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="source_url",
     *      description="A source attribution for the post content",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="slug",
     *      description="Add a short text summary to the end of the post URL",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="send_to_twitter",
     *      description="Whether or not to share this via any connected Twitter account on post publish",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="is_private",
     *      description="Whether this should be a private answer, if this is an answer.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="send_to_facebook",
     *      description="Whether or not to share this via any connected Facebook account on post publish",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=201,
     *          description="Successfully Created",
     *       ),
     *)
     **/


        
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
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * @OA\Put(
     ** path="/posts/edit",
     *   tags={"posts"},
     *   summary="Edit existing Post",
     *   operationId="edit",
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="the ID of the post to edit",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Successfully edited",
     *       ),
     *)
     **/

    /**
     * @OA\Post(
     ** path="/post/{post-id}",
     *   tags={"posts"},
     *   summary="fetch a post for editing",
     *   operationId="edit",
     *
     *   @OA\Parameter(
     *      name="post_fromat",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="successful post fetching",
     *       ),
     *)
     **/



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posts $posts)
    {
        //
    }

    /**
     * @OA\Delete(
     ** path="/post/delete",
     *   tags={"posts"},
     *   summary="delete existing post",
     *   operationId="destroy",
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="the ID of the post to delete",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="successfully deleted",
     *       ),
     *)
     **/



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }
    /**
     * @OA\Post(
     ** path="/posts/reblog",
     *   tags={"posts"},
     *   summary="Reblog existing Post",
     *   operationId="reblog",
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="the ID of the reblogged post",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="reblog_key",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="comment",
     *      in="query",
     *      description="comment added to the reblogged post",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="native_inline_images",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *          response=201,
     *          description="Successfully Created",
     *       ),
     *)
     **/

     /**
     * Reblog existing post 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function reblog (Request $request)
      {
          //
      }
}