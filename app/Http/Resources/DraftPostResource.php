<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DraftPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'post_id' => $this->id,
            'type' => $this->type,
            'state' => $this->state,
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
            'source_content' => $this->source_content,
            'tags' => $this->tags
        ];
    }
}