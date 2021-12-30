<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostNotesCollection;
use App\Services\Post\PostNotesService;
use Illuminate\Http\Request;

class PostNotesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PostNotesController Controller 
    |--------------------------------------------------------------------------|
    | This controller handles getting notes for specific post  
    |
   */
    protected $postNotesService;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(PostNotesService $postNotesService)
    {
        $this->postNotesService = $postNotesService;
    }

 /**
     * @OA\GET(
     * path="/post/notes",
     * summary="getting notes for specific post",
     * description="This method can be used to get notes for specific post",
     * operationId="getNotes",
     * tags={"Posts"},
     *  @OA\Parameter(
     *         name="post_id",
     *         in="query",
     *         required=true,
     *      ),
     * 
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="id", type="Number", format="text", example="1234567890000"),
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
     * get post notes 
     *
     * @param integer $post_id
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Yousif Ahmed
     */
    public function getNotes(Request $request )
    {
        $postId = (int)$request->post_id;
        
        $notes =  $this->postNotesService->GetPostNotes($postId);
        
        // checking null
        if ( ! $notes->first())
        {
            return response()->json( ['notes'=> $notes ,'total_likes' => 0 ,'total_reblogs'=>0,'total_replys'=>0] , 200);
        }
        return response()->json( new PostNotesCollection($notes) , 200);

    }
 
}