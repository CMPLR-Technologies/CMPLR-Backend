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
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=201),
     *           @OA\Property(property="msg", type="string", example="Created"),
     *           ),
     *           @OA\Property(property="response", type="object",
     *           @OA\Property(property="id", type="integer", example=1234567891234567),
     *           ),
     *       ),
     *         
     *          
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
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="id", type="number", format="text", example="12546899"),
     *    ),
     * ),
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
     *          @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=200),
    *           @OA\Property(property="msg", type="string", example="OK"),
    *           ),
    *       ),
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
     *      
     *    ),
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
     *           @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="Meta", type="object",
    *           @OA\Property(property="Status", type="integer", example=201),
    *           @OA\Property(property="msg", type="string", example="Created"),
    *           ),
    *       ),
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
      
      /**
    * @OA\GET(
    * path="post/notes",
    * summary="getting notes for specific post",
    * description="This method can be used to get notes for specific post",
    * operationId="getNotes",
    * tags={"posts"},
    *  @OA\Parameter(
    *         name="blog-identifier",
    *         in="query",
    *         required=true,
    *      ),
    *   @OA\Parameter(
     *      name="before_timestamp",
     *      in="query",
     *      description="Fetch notes created before this timestamp",
     *      required=false,
     *      @OA\Schema(
     *          type="Number"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="mode",
     *      in="query",
     *      description="The response formatting mode {all , likes , conversation , rollup ,reblogs_with_tags }",
     *      required=false,
     *      @OA\Schema(
     *          type="String"
     *      )
     *   ),
     *  @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"id"},
    *       @OA\Property(property="id", type="Number", format="text", example="1234567890000"),
    *       @OA\Property(property="before_timestamp", type="Number", format="text", example="1234567890"),
    *       @OA\Property(property="mode", type="string", format="text", example="all"),
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
    *    description="success",
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
    *                         property="notes",
    *                         type="Array",
    *                      ),
    *                      @OA\Property(
    *                         property="rollup_notes",
    *                         type="Array",
    *                      ),
    *                      @OA\Property(
    *                         property="total_notes",
    *                         type="Number",
    *                         example=125
    *                      ),
    *                      @OA\Property(
    *                         property="total_likes",
    *                         type="Number",
    *                         example=12
    *                      ),
    *                    @OA\Property(
    *                         property="_links",
    *                         type="Object",
    *                         example= "http/...."
    *                      ),
    *                ),
    *       
    *               ),           
    *           ),
    *        ),
    *     )
    * )
    */

      /**
     * Reblog existing post 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function getNotes (Request $request)
    {
        //
    }
}