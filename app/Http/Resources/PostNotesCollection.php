<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostNotesCollection extends ResourceCollection
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
            'notes' => $this->collection[0][0] ,
            'total_likes'=> $this->collection[0][1]->like,
            'total_reblogs'=> $this->collection[0][1]->reblog,
            'total_replys' => $this->collection[0][1]->reply
         ];
    }
}
