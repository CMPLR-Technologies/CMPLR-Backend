<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TagUser;
use App\Models\PostTags;
use Illuminate\Http\Request;
use App\Http\Misc\Helpers\Errors;
use App\Services\Posts\PostsService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TagCollection;
use App\Services\User\UserTagsService;


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
     *   operationId="follow tag",
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
     *   operationId="unfollow tag",
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
        $response['tag_avatar'] = ($tagPost)?$this->postsService->GetViews([$tagPost]):null;

        //total tag posts 
        $response['total_posts'] = PostTags::where('tag_name', $tag)->count();

        return response()->json($response, 200);
    }

    public function GetFollowedTags()
    {
        // getting current user
        $user = auth()->user();

        if (!$user)
            return $this->error_response(Errors::ERROR_MSGS_401, '', 401);

        $followed_tags = $this->userTagsService->GetFollowedTags($user->id);

        $response = $this->success_response($followed_tags);

        return $response;
    }

    public function GetRecommendedTags()
    {
        $recommended_tags = $this->userTagsService->GetRandomTagsData();

        foreach ($recommended_tags as $tag) {
            $posts = $this->userTagsService->GetTagPosts($tag['name']);
            $tag['posts_views'] = $this->postsService->GetViews($posts);
        }

        $response = $this->success_response(new TagCollection($recommended_tags));

        return $response;
    }

    public function GetTrendingTags()
    {
        $trending_tags = $this->userTagsService->GetRandomTagsData();

        foreach ($trending_tags as $tag) {
            $posts = $this->userTagsService->GetTagPosts($tag['name']);
            $tag['posts_views'] = $this->postsService->GetViews($posts);
        }

        $response = $this->success_response(new TagCollection($trending_tags));

        return $response;
    }
}
