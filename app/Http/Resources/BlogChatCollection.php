<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogChatCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blogData = Blog::where('id',$this->collection[0]->to_blog_id)->first();
        return 
        [
            'messages' => $this->collection,
            'blog_data'=>[
                'blog_name' => $blogData->blog_name,
                'url' => $blogData->url,
                'title' => $blogData->title,
                'avatar' => $blogData->settings->avatar,
                'avatar_shape' => $blogData->settings->avatar_shape
            ],
            'next_url' => $this->nextPageUrl(),
            'total' => $this->total(),
            'current_page' => $this->currentPage(),
            'messages_per_page' => $this->perPage(),
        ];
       
    }
}
