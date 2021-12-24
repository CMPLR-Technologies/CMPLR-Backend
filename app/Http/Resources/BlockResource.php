<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blogSettings=$this->settings;

        return [
            'blocked_id'=>$this->id,
            'blocked_name'=>$this->blog_name,
            'avatar'=>$blogSettings->avatar,
            'avatar_shape'=>$blogSettings->avatar_shape,
        ];

    }
}
