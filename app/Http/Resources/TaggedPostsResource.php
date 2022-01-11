<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\JsonResource;

class TaggedPostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user =  auth('api')->user();
        $blog = Blog::where('id' , $this->blog_id)->first();
        $blog_settings = $blog->settings;
        return [
            'post' => [
                'post_id' => $this->id,
                'type' => $this->type,
                'state' => $this->state,
                'content' => $this->content,
                'date' => $this->date,
                'source_content' => $this->source_content,
                'tags' => $this->tags,
                'is_liked' => $this->is_liked(),
                'notes_count' => $this->count_notes(),
            ],
            'blog' => [
                'blog_id' => $blog->id,
                'blog_name' => $blog->blog_name,
                'avatar' => $blog_settings->avatar,
                'avatar_shape' => $blog_settings->avatar_shape,
                'replies' => $blog_settings->replies,
                'follower' => ($user)?$blog->isfollower($user):null
            ]
        ];
    }
}
