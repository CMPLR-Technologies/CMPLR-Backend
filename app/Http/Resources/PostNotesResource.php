<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\JsonResource;

class PostNotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       $user = $this->user;
       $blogData =$user->PrimaryBlogInfo;
         return [
            'post_id'=>$this->post_id,
            'type' => $this->type,
            'content'=> $this->content,
            'timestamp'=>$this->created_at,
            'blog_name'=>$blogData->blog_name,
            'blog_url'=>$blogData->url,
            'avatar'=> $blogData->settings->avatar ,
            'avatar_shape'=>$blogData->settings->avatar_shape,

        ];
    }
}
