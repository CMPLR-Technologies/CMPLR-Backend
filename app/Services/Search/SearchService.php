<?php

namespace App\Services\Search;

use App\Models\Tag;
use App\Models\Blog;


class SearchService
{
    /**
     * Getting the tags which includes the query
     * 
     * @param string $query
     * 
     * @return Tag $tags
     * 
     * @author Abdullah Adel
     */
    public function GetSearchTags($query)
    {
        return Tag::where('name', 'like', '%' . $query . '%')->limit(5)->orderBy('name', 'asc')->get(['name', 'slug']);
    }

    /**
     * Getting the blogs which name or title includes the query
     * 
     * @param string $query
     * 
     * @return Blog $blogs
     * 
     * @author Abdullah Adel
     */
    public function GetSearchBlogs($query)
    {
        return Blog::with('settings:blog_id,avatar,avatar_shape')->where([['blog_name', 'like', '%' . $query . '%']])->orWhere([['title', 'like', '%' . $query . '%']])->limit(5)->orderBy('blog_name', 'asc')->get(['id', 'blog_name', 'title']);
    }
}