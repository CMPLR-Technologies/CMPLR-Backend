<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, $query)
    {
        $tags = Tag::where('name', 'like', '%' . $query . '%')->limit(5)->orderBy('name', 'asc')->get();
        $blogs = Blog::with('settings')->where('blog_name', 'like', '%' . $query . '%')->limit(5)->orderBy('blog_name', 'asc')->get();

        // $tagsRes = [[]];
        // foreach ($tags as $tag) {
        //     dd($request->user->id);
        //     dd($tag->users()->where('user_id', $request->user()->id)->get());
        //     $isFollowing = $tag->where('user_id', $request->user()->id)->get();
        //     $tagsRes[] = [
        //         'tag' => $tag->name,
        //         'featured' => $isFollowing,
        //     ];
        // }

        $response = [
            'meta' => [
                'status' => 200,
                'msg' => 'Success',
            ],
            'response' => [
                'blogs' => $blogs,
                'tags' => $tags,
            ],
        ];

        return response($response, 200);
    }
}
