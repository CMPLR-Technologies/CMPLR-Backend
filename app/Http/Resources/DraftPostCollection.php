<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DraftPostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'posts' => $this->collection,
            'next_url' => $this->nextPageUrl(),
            'total' => $this->total(),
            'current_page' => $this->currentPage(),
            'posts_per_page' => $this->perPage(),
        ];
    }
}