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
        $notesCounts = (object) $this->collection[0]->post_notes_count();
        return [
            'notes' => $this->collection,
            'total_likes' => (int)$notesCounts->like,
            'total_reblogs' => (int)$notesCounts->reblog,
            'total_replys' => (int)$notesCounts->reply
        ];
    }
}
