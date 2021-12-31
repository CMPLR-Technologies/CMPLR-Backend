<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Misc\Helpers\Errors;
use App\Services\Search\SearchService;

class SearchController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SearchController Controller 
    |--------------------------------------------------------------------------|
    | This controller handles search results 
    |
   */

    private $searchService;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @OA\Get(
     *      path="/search/{query}",
     *      operationId="Search",
     *      tags={"Search"},
     *      summary="Get search autocomplete",
     *      description="Returns list of tags and blogs which contains the searched query",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="Status", type="integer", example=200),
     *                  @OA\Property(property="msg", type="string", example="ok"),
     *              ),
     *              @OA\Property(property="response", type="object",
     *                  @OA\Property(property="tags", type="array", collectionFormat="multi",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="name", type="string", example="Tag Name"),
     *                          @OA\Property(property="slug", type="string", example="tag-name"),
     *                      ),
     *                  ),
     *                   @OA\Property(property="blogs", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id", type="integer", example=5),
     *                          @OA\Property(property="blog_name", type="string", example="necessitatibus"),
     *                          @OA\Property(property="title", type="string", example="Moses Rath"),
     *                          @OA\Property(property="settings", type="object",
     *                              @OA\Property(property="blog_id", type="integer", example=5),
     *                              @OA\Property(property="avatar", type="string", example="https://assets.tumblr.com/images/default_avatar/cone_closed_128.png"),
     *                              @OA\Property(property="avatar_shape", type="string", example="circle"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid Data",
     *      )
     *     )
     */
    /**
     * Search autocomplete.
     * This controller returns the tags and blogs that
     * contains the query string
     *
     * @param Request $request
     * @param string $query
     * 
     * @return \Illuminate\Http\Response
     * 
     * @author Abdullah Adel
     */
    public function Search(Request $request, $query)
    {
        $query = Str::of($query)->trim();

        if ($query == '') {
            return $this->error_response(Errors::ERROR_MSGS_400, 'Enter a search query');
        }

        $tags = $this->searchService->GetSearchTags($query);
        $blogs = $this->searchService->GetSearchBlogs($query);

        $response = [
            'tags' => $tags,
            'blogs' => $blogs
        ];

        return $this->success_response($response);
    }
}