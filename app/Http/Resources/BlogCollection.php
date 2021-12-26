<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use phpDocumentor\Reflection\Types\This;

class BlogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return 
        [
            'blogs'=>$this->collection,
            'total_following' => $this->total(),
            'next_url' => $this->nextPageUrl(),
            'current_page' => $this->currentPage(),
            'next_page' =>$this->currentPage()+1,
            'posts_per_page' => $this->perPage(),
            'ahmed' => 'true'
        ];
    }
}
