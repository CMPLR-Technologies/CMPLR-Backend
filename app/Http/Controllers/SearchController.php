<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, $query)
    {
        $tags = Tag::where('name', 'like', '%' . $query . '%')->limit(5)->orderBy('name', 'asc')->get(['name', 'slug']);
        $blogs = Blog::with('settings:blog_id,avatar,avatar_shape')->where('blog_name', 'like', '%' . $query . '%')->limit(5)->orderBy('blog_name', 'asc')->get(['id', 'blog_name', 'title']);

        $response = [
            'meta' => [
                'status' => 200,
                'msg' => 'success',
            ],
            'response' => [
                'tags' => $tags,
                'blogs' => $blogs,
            ],
        ];

        return response($response, 200);
    }
}