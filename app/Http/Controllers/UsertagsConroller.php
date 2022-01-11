<?php

namespace App\Http\Controllers;

use App\Models\PostTags;
use Illuminate\Http\Request;
use App\Http\Misc\Helpers\Errors;
use App\Services\Posts\PostsService;
use App\Http\Resources\TagCollection;
use App\Services\User\UserTagsService;
use Illuminate\Support\Carbon;

class UserTagsConroller extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | UsertagsConroller
     |--------------------------------------------------------------------------|
     | This Service handles all UserTags  
     |
     */
    protected $userTagsService;
    protected $postsService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(UserTagsService $userTagsService, PostsService $postsService)
    {
        $this->userTagsService = $userTagsService;
        $this->postsService = $postsService;
    }

    /**
     * @OA\Post(
     *   path="/user/tags/add",
     *   tags={"Users"},
     *   summary="follow new tag",
     *   operationId="FollowTag",
     *  @OA\Parameter(
     *      name="tag_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     *          description="Success",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="ok"),
     *           ),
     *       ),
     *         
     *          
     *       ),
     *)
     **/
    /**
     * user follow specific tag
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Yousif Ahmed 
     */
    public function FollowTag(Request $request)
    {
        // getting current user
        $user = auth()->user();
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        //getting tag name 
        $tagName = $request->tag_name;

        if (!$this->userTagsService->UserFollowTag($tagName, $user->id)) {

            return $this->error_response(Errors::ERROR_MSGS_400, 'error while follow tag', 400);
        }
        return $this->success_response('Success', 200);
    }


    /**
     * @OA\Delete(
     *   path="/user/tags/remove",
     *   tags={"Users"},
     *   summary="unfollow tag",
     *   operationId="UnFollowTag",
     *  @OA\Parameter(
     *      name="tag_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     *          description="Success",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="Meta", type="object",
     *           @OA\Property(property="Status", type="integer", example=200),
     *           @OA\Property(property="msg", type="string", example="ok"),
     *           ),
     *       ),
     *         
     *          
     *       ),
     *)
     **/
    /**
     * user unfollow specific tag
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Yousif Ahmed 
     */
    public function UnFollowTag(Request $request)
    {
        // getting current user
        $user = auth()->user();
        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);
        //getting tag name 
        $tagName = $request->tag_name;
        if (!$this->userTagsService->UserUnFollowTag($tagName, $user->id)) {
            return $this->error_response(Errors::ERROR_MSGS_400, 'error while unfollow tag', 400);
        }

        return $this->success_response('Success', 200);
    }
    /**
     * @OA\GET(
     *   path="tag/info",
     *   tags={"Users"},
     *   summary="getting tag info",
     *   operationId="GetTagInfo",
     *  @OA\Parameter(
     *      name="tag_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     *  @OA\Response(
     *      response=404,
     *      description="Not Found"
     *   ),
     *   @OA\Response(
     *          response=200,
     *          description="Success",
     *           @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="total_followers", type="integer", example="10"),
     *           @OA\Property(property="is_follower", type="boolean", example="true"),
     *           @OA\Property(property="tag_avatar", type="string", example="null"),
     *           @OA\Property(property="total_posts", type="integer", example="55"),
     *           @OA\Property(property="tags", type="string", example="[summer , winter ,football]"),
     * ),
     *       ),
     *         
     *         
     * 
     *  
     *       ),
     *)
     **/

    /**
     * getting info of specific tag
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Yousif Ahmed 
     */
    public function GetTagInfo(Request $request)
    {
        $tag = $request->tag;
        if (!$tag)
            return $this->error_response(Errors::ERROR_MSGS_404, 'tag not found', 404);


        // getting random tags 
        $response['tags'] = $this->userTagsService->GetRandomTags();

        // getting total followers        
        $response['total_followers'] = $this->userTagsService->GetTotalTagsFollowers($tag);

        // check if user follow 
        $response['is_follower'] = $this->userTagsService->IsFollower($tag);

        // getting tag avatar 
        $tagPost = $this->postsService->GetPostWithTagPhoto($tag);
        $response['tag_avatar'] = ($tagPost) ? $this->postsService->GetViews([$tagPost]) : null;

        //total tag posts 
        $response['total_posts'] = PostTags::where('tag_name', $tag)->count();

        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *   path="/following/tags",
     *   summary="Retrieve the user's followed tags",
     *   description="Retrieve the user's followed tags",
     *   operationId="GetFollowedTags",
     *   tags={"Explore"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status_code", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="Success"),
     *       ),
     *       @OA\Property(property="response", type="array",
     *           @OA\Items(type="object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="asperiores"),
     *              @OA\Property(property="slug", type="string", example="asperiores"),
     *              @OA\Property(property="posts_count", type="integer", example=7),
     *              @OA\Property(property="cover_image", type="object",
     *                  @OA\Property(property="link", type="string", example="https://via.placeholder.com/640x480.png/007799?text=sit"),
     *                  @OA\Property(property="post_id", type="integer", example=6),
     *              ),
     *           )
     *         ),
     *       )
     *   ),
     * security ={{"bearer":{}}}
     * )
     */

    /**
     * Get the tags that the user follows
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Abdullah Adel
     */
    public function GetFollowedTags()
    {
        // getting current user
        $user = auth()->user();

        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);

        $followed_tags = $this->userTagsService->GetFollowedTags($user->id);

        foreach ($followed_tags as $tag) {
            $tag_posts = $this->userTagsService->GetTagPosts($tag['name']);
            $tag['posts_count'] = $this->userTagsService->GetTagRecentPostsCount($tag_posts);
            $tag['cover_image'] = $this->postsService->GetViews($tag_posts);
            if (!$tag['cover_image']) {
                $tag['cover_image'] = "";
            } else {
                $tag['cover_image'] = $tag['cover_image'][0];
            }
        }

        $response = $this->success_response($followed_tags);

        return $response;
    }

    /**
     * @OA\Get(
     *   path="/recommended/tags",
     *   summary="Retrieve recommended tags",
     *   description="Retrieve recommended tags for the explore",
     *   operationId="GetRecommendedTags",
     *   tags={"Explore"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status_code", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="Success"),
     *       ),
     *       @OA\Property(property="response", type="object",
     *         @OA\Property(property="tags", type="array",
     *           @OA\Items(type="object",
     *              @OA\Property(property="tag_id", type="integer", example=1),
     *              @OA\Property(property="tag_name", type="string", example="asperiores"),
     *              @OA\Property(property="tag_slug", type="string", example="asperiores"),
     *              @OA\Property(property="posts_views", type="array",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="link", type="string", example="https://via.placeholder.com/640x480.png/007799?text=sit"),
     *                      @OA\Property(property="post_id", type="integer", example=44),
     *                  ),
     *              ),
     *          )
     *         ),
     *         @OA\Property(property="next_url", type="string", example="https://www.cmplr.tech/api/recommended/tags?page=2"),
     *         @OA\Property(property="total", type="number", example=36),
     *         @OA\Property(property="current_page", type="number", example=1),
     *         @OA\Property(property="tags_per_page", type="number", example=4),
     *         )
     *       )
     *     )
     *   ),
     * security ={{"bearer":{}}}
     * )
     */

    /**
     * Get recommended tags for explore
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Abdullah Adel
     */
    public function GetRecommendedTags()
    {
        // Check if there is an authenticated user
        $user = auth('api')->user();
        $user_id = null;

        if ($user) {
            $user_id = $user->id;
        }

        $recommended_tags = $this->userTagsService->GetRandomTagsData($user_id);

        foreach ($recommended_tags as $tag) {
            $posts = $this->userTagsService->GetTagPosts($tag['name']);
            $tag['posts_views'] = $this->postsService->GetViews($posts);
        }

        $response = $this->success_response(new TagCollection($recommended_tags));

        return $response;
    }

    /**
     * @OA\Get(
     *   path="/trending/tags",
     *   summary="Retrieve trending tags",
     *   description="Retrieve trending tags for the explore",
     *   operationId="GetTrendingTags",
     *   tags={"Explore"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="status_code", type="integer", example=200),
     *         @OA\Property(property="msg", type="string", example="Success"),
     *       ),
     *       @OA\Property(property="response", type="object",
     *         @OA\Property(property="tags", type="array",
     *           @OA\Items(type="object",
     *              @OA\Property(property="tag_id", type="integer", example=1),
     *              @OA\Property(property="tag_name", type="string", example="asperiores"),
     *              @OA\Property(property="tag_slug", type="string", example="asperiores"),
     *              @OA\Property(property="posts_views", type="array",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="link", type="string", example="https://via.placeholder.com/640x480.png/007799?text=sit"),
     *                      @OA\Property(property="post_id", type="integer", example=44),
     *                  ),
     *              ),
     *          )
     *         ),
     *         @OA\Property(property="next_url", type="string", example="https://www.cmplr.tech/api/trending/tags?page=2"),
     *         @OA\Property(property="total", type="number", example=36),
     *         @OA\Property(property="current_page", type="number", example=1),
     *         @OA\Property(property="tags_per_page", type="number", example=4),
     *         )
     *       )
     *     )
     *   ),
     * security ={{"bearer":{}}}
     * )
     */

    /**
     * Get trending tags for explore
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Abdullah Adel
     */
    public function GetTrendingTags()
    {
        // Check if there is an authenticated user
        $user = auth('api')->user();
        $user_id = null;

        if ($user) {
            $user_id = $user->id;
        }

        $trending_tags = $this->userTagsService->GetRandomTagsData($user_id);

        foreach ($trending_tags as $tag) {
            $posts = $this->userTagsService->GetTagPosts($tag['name']);
            $tag['posts_views'] = $this->postsService->GetViews($posts);
        }

        $response = $this->success_response(new TagCollection($trending_tags));

        return $response;
    }
}