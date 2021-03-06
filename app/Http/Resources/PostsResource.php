<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
     
        $blog = $this->BLogs;
        $blog_settings = $blog->settings;
        return [
            'post' => [
                'post_id' => $this->id,
                'type' => $this->type,
                'state' => $this->state,
                'title' => $this->title,
                'content' => $this->content,
                'date' => $this->date,
                'source_content' => $this->source_content,
                'tags' => $this->tags,
                'is_liked' => $this->is_liked(),
                'notes_count' => $this->count_notes(),
                'is_mine' => $blog->IsMine(),
            ],
            'blog' => [
                'blog_id' => $blog->id,
                'blog_name' => $blog->blog_name,
                'avatar' => $blog_settings->avatar,
                'avatar_shape' => $blog_settings->avatar_shape,
                'replies' => $blog_settings->replies,
                'follower' => $blog->isfollower()
               
            ]
        ];
    }
}
