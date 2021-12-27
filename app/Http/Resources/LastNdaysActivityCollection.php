<?php

namespace App\Http\Resources;

use App\Models\Follow;
use App\Models\PostNotes;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LastNdaysActivityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blog=$this->collection[0][0];
        $lastNdays=$this->collection[0][2];

        $postsIds=$blog->Posts()->pluck('id')->toArray();

        $notes=PostNotes::whereIn('post_id',$postsIds)->whereBetween('created_at',[now()->subDays($lastNdays)->format('Y-m-d'),now()->format('Y-m-d')])->count();
        $newFollowers=Follow::where('blog_id',$blog->id)->whereBetween('created_at',[now()->subDays($lastNdays)->format('Y-m-d'),now()->format('Y-m-d')])->count();
        $totalFollowers=Follow::where('blog_id',$blog->id)->where('created_at','<',now()->format('Y-m-d'))->count();

        return [
            $this->collection->groupBy(function($item){ return $item[1]->format('d-m-y'); }),
            'notes'=>$notes,
            'new followers'=>$newFollowers,
            'total followers'=>$totalFollowers
        ];
    }
}
