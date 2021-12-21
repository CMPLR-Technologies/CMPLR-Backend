<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blog_settings = $this->settings;
        return [
            'blog_id'=>$this->id,
            'blog_name'=>$this->blog_name,
            'title' => $this->title,
            'avatar' => $blog_settings->avatar,
        ];
    }
}
