<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
    * @OA\GET(
    * path="user/info",
    * summary=" retrieving the user’s account information ",
    * description="This method can be used to  retrieve the user’s account information that matches the OAuth credentials submitted with the request",
    * operationId="index",
    * tags={"users"},
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
    *             @OA\Property(property="following", type="Number", example=263),
    *             @OA\Property(property="default_post_format", type="String",description="html, markdown, or raw", example="html"),     
    *             @OA\Property(property="name", type="String",description="The user's tumblr short name", example="derekg"),      
    *             @OA\Property(property="likes", type="Number",description="The total count of the user's likes", example=606),                                            
    *             @OA\Property(property="blogs", type="array",
    *                @OA\Items(
    *                      @OA\Property(
    *                         property="name",
    *                         description="the short name of the blog",
    *                         type="String",
    *                         example="derekg",
    *                      ),
    *                      @OA\Property(
    *                         property="url",
    *                         description="the URL of the blog",
    *                         type="String",
    *                         example=  "https://derekg.org/",
    *                      ),
    *                      @OA\Property(
    *                         property="title",
    *                         type="String",
    *                         description="the title of the blog",
    *                         example= "Derek Gottfrid",
    *                      ),
    *                      @OA\Property(
    *                         property="primary",
    *                         type="Boolean",
    *                         description="indicates if this is the user's primary blog",
    *                         example=true
    *                      ),
    *                    @OA\Property(
    *                         property="followers",
    *                         type="Number",
    *                         description="total count of followers for this blog",
    *                         example= 33004929
    *                      ),
    *                      @OA\Property(
    *                         property="tweet",
    *                         type="String",
    *                         description="indicate if posts are tweeted auto, Y, N",
    *                         example= "Y"
    *                      ),
    *                        @OA\Property(
    *                         property="facebook",
    *                         type="String",
    *                         description="indicate if posts are sent to facebook Y, N",
    *                         example= "auto"
    *                      ),
    *                       @OA\Property(
    *                         property="type",
    *                         type="String",
    *                         description="indicates whether a blog is public or private",
    *                         example= "public"
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
     * Display a listing of user info.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index()
    {
        //
    }
   /**
    * @OA\GET(
    * path="user/dashboard",
    * summary=" retrieving the user’s dashboard",
    * description="This method can be used to  retrieve the user’s dashboard that matches the OAuth credentials submitted with the request",
    * operationId="index",
    * tags={"users"},
     *   @OA\Parameter(
     *      name="limit",
     *      description="The number of results to return: 1–20, inclusive",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *    @OA\Parameter(
     *      name="offset",
     *      description="Post number to start at",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="type",
     *      description="The type of post to return. Specify one of the following: text, photo, quote, link, chat, audio, video, answer",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="String"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="since_id",
     *      description="Return posts that have appeared after this ID; Use this parameter to page through the results: first get a set of posts, and then get posts since the last ID of the previous set.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Number"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="reblog_info",
     *      description="Indicates whether to return reblog information (specify true or false). Returns the various reblogged_ fields.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="notes_info",
     *      description="Indicates whether to return notes information (specify true or false). Returns note count and note metadata.",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="Boolean"
     *      )
     *   ),
     * 
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
     *     ),
     * 
        * )
        */


    /**
     * Display a dashboard of user info.
     *
     * @return \Illuminate\Http\Response
     */  
    public function getDashboard()
    {
        //
    }
}
