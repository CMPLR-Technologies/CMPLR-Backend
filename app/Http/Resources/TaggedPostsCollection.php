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
        $user = auth('api')->user() ;
        //if ($user->is_Empty)
//            $is_followers = count(TagUser::where([['tag_name'=>$this->tag],['user_id'=>$user->id ]] )->first())>0;
         return
            [
                'post' => $this->collection,
                'next_url' => $this->nextPageUrl(),
                'total' => $this->total(),
                'current_page' => $this->currentPage(),
                'posts_per_page' => $this->perPage(),
            ];
    }
}
