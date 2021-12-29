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

        $notes=PostNotes::whereIn('post_id',$postsIds)
                        ->whereBetween('created_at',[now()->subDays($lastNdays-1)->format('Y-m-d').' 00:00:00',now()->format('Y-m-d').' 23:59:59'])
                        ->count();

        $newFollowers=Follow::where('blog_id',$blog->id)
                    ->whereBetween('created_at',[now()->subDays($lastNdays-1)->format('Y-m-d').' 00:00:00',now()->format('Y-m-d').' 23:59:59'])
                    ->count();

        $totalFollowers=Follow::where('blog_id',$blog->id)
                    ->where('created_at','<=',now()->format('Y-m-d').' 23:59:59')
                    ->count();

        return [
            'data'=>$this->collection,
            'notes'=>$notes,
            'new_followers'=>$newFollowers,
            'total_followers'=>$totalFollowers
        ];
    }
}
