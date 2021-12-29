<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\JsonResource;

class BLogFollowersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blog = Blog::where('id',$this->primary_blog_id)->first();
        $blog_settings = $blog->settings;
       return[
            'blog_id' => $blog->id,
            'blog_name' => $blog->blog_name,
            'title' => $blog->title,
            'avatar' => $blog_settings->avatar,
            'avatar_shape' => $blog_settings->avatar_shape,
            'is_follower' => $blog->IsFollowerToMe(),

       ];
    }
}
