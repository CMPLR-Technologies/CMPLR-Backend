<?php

namespace App\Http\Resources;

use App\Models\TagUser;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaggedPostsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_followers = TagUser::where('tag_name',$this->tag )->count();
         return
            [
                'post' => $this->collection,
                'next_url' => $this->nextPageUrl(),
                'total' => $this->total(),
                'current_page' => $this->currentPage(),
                'posts_per_page' => $this->perPage(),
                'total_followers'=>$total_followers ,
                'tag_avatar'=>'https://assets.tumblr.com/images/default_avatar/cone_closed_128.png' ,
            ];
    }
}
