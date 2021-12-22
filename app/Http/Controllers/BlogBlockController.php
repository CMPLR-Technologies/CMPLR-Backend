<?php

namespace App\Http\Controllers;

use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Helpers\Success;
use App\Http\Resources\BlockCollection;
use App\Services\Block\BlockService;
use Illuminate\Http\Request;

class BlogBlockController extends Controller
{
    /**
     * @OA\Get(
     *   path="/blog/{blog-identifier}/blocks",
     *   summary="Retrieve Blog's Block",
     *   description="Get the blogs that the requested blog is currently blocking. The requesting user must be an admin of the blog to retrieve this list.",
     *   operationId="getBlogBlocks",
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
     *         @OA\Property(property="blocked_blogs", type="array",
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
     *   security ={{"bearer":{}}}
     * )
     */
    public function GetBlogBlocks($blogName)
    {
        //call service to do the logic
        [$code,$blocks] = (new BlockService())->GetBlogBlocks($blogName,auth()->user());

        //response with the appropriate response        
        if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else if ($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not authorized to get the blocks',403);
        else
            return $this->success_response(new BlockCollection($blocks),200);
    }

    /**
     * @OA\Post(
     *   path="/blog/{blogName}/blocks",
     *   summary="Block a Blog",
     *   description="Block a blog by sending its blogName",
     *   operationId="blockBlog",
     *   tags={"Blogs"},
     * 
     *   @OA\Parameter(
     *     name="blockName",
     *     in="path",
     *     description="the name of the blog to block",
     *     required=true,
     *   ),
     * 
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="blocked_blog", type="string", format="text", example="john-doe"),
     *    )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       )
     *     )
     *   ),
     *   security ={{"bearer":{}}}
     * )
     */
    public function BlockBlog(Request $request,$blogName)
    {
        //validate input parameters
        $this->validate($request,[
            'blockName'=>'required | String'
        ]);
        
        //call service to do the logic
        $code = (new BlockService())->BlockBlog($request->blockName,$blogName,auth()->user());

        //response with the appropriate response        
        if ($code == 409)
            return $this->error_response(Errors::ERROR_MSGS_409,'Already blocked',409);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else if ($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not authorized to block a blog',403);
        else
            return $this->success_response('Blocked',200);

    }

    /**
     * @OA\Delete(
     *   path="/blog/{blog-identifier}/blocks",
     *   summary="Remove a Block",
     *   description="Remove a block by sending its identifier",
     *   operationId="unblockBlog",
     *   tags={"Blogs"},
     *   @OA\Parameter(
     *     name="blog-identifier",
     *     in="path",
     *     description="Your blog identifier",
     *     required=true,
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="blocked_blog", type="string", format="text", example="john-doe"),
     *    )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="OK"),
     *       )
     *     )
     *   ),
     *   security ={{"bearer":{}}}
     * )
     */
    public function UnblockBlog(Request $request,$blogName)
    {
        //validate input parameters
        $this->validate($request,[
            'blockName'=>'required | string'
        ]);

        //call service to do the logic
        $code = (new BlockService())->Unblockblog($request->blockName,$blogName,auth()->user());


        //response with the appropriate response        
        if ($code == 409)
            return $this->error_response(Errors::ERROR_MSGS_409,'Already unblocked',409);
        else if ($code == 404)
            return $this->error_response(Errors::ERROR_MSGS_404,'Blog name is not available!',404);
        else if ($code==403)
            return $this->error_response(Errors::ERROR_MSGS_403,'user is not authorized to unblock a blog',403);
        else
            return $this->success_response('Unblocked',200);
    }
}
