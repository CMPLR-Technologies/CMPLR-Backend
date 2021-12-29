<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\JsonResource;

class LatestMessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth('api')->user();
        $userBlogData = $user->blogs->pluck('blog_id')->toArray();
        $blogId = (!in_array($this->from_blog_id, $userBlogData)) ? $this->from_blog_id : $this->to_blog_id;
        $blogData = Blog::where('id', $blogId)->first();
        return [
            'from_blog_id' => $this->from_blog_id,
            'to_blog_id' => $this->to_blog_id,
            'content' => $this->content,
            'is_read' => $this->is_read,
            'blog_data' => [
                'blog_id' => $blogId,
                'blog_name' => $blogData->blog_name,
                'blog_url' => $blogData->url,
                'avatar'   => $blogData->settings->avatar,
                'avatar_shape' => $blogData->settings->avatar_shape,

            ]

        ];
    }
}
