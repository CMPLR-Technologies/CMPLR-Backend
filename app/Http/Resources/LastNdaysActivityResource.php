<?php

namespace App\Http\Resources;

use App\Models\Blog;
use App\Models\Follow;
use App\Models\PostNotes;
use Illuminate\Http\Resources\Json\JsonResource;

class LastNdaysActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blog=$this[0];

        // dd(Follow::where('blog_id',$blog->id)->whereDate('created_at',now()->format('Y-m-d'))->get());

        // dd([$this[1]->format('Y-m-d'),Follow::all()->first()->created_at->format('Y-m-d')]);

        $postsIds=$blog->Posts()->pluck('id')->toArray();

        $notes=PostNotes::whereIn('post_id',$postsIds)->whereDate('created_at',$this[1]->format('Y-m-d'))->count();
        $newFollowers=Follow::where('blog_id',$blog->id)->whereDate('created_at',$this[1]->format('Y-m-d'))->count();
        $totalFollowers=Follow::where('blog_id',$blog->id)->where('created_at','<=',$this[1]->format('Y-m-d').' 23:59:59')->count();

        return [
            'notes'=>$notes,
            'new followers'=>$newFollowers,
            'total followers'=>$totalFollowers,
            'date'=>$this[1]->format('d-m-Y')
        ];
    }
}
