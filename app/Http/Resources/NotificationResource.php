<?php

namespace App\Http\Resources;

use App\Models\Blog;
use App\Models\Follow;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $to_blog=Blog::find($this->to_blog_id);
        $from_blog=Blog::find($this->from_blog_id);
        $from_blog_settings=$from_blog==null?null:$from_blog->settings;
        $post=Post::find($this->post_ask_answer_id);
        
        $doYouFollow=true;

        if($from_blog != null && $from_blog->followers()->where('user_id',auth()->user()->id)->count()==0)
            $doYouFollow=false;

        return [
            'notification_id'=>$this->id,
            'from_blog_id'=>$this->from_blog_id,
            'from_blog_name'=>$from_blog==null?null:$from_blog->blog_name,
            'from_blog_avatar'=>$from_blog_settings==null?null:$from_blog_settings->avatar,
            'from_blog_avatar_shape'=>$from_blog_settings==null?null:$from_blog_settings->avatar_shape,
            'to_blog_id'=>$this->to_blog_id,
            'to_blog_name'=>$to_blog->blog_name,
            'type'=>$this->type,
            'seen'=>$this->seen,
            'post_ask_answer_id'=>$this->post_ask_answer_id,
            'post_ask_answer_content'=>$post==null?null:$post->content,
            'do_you_follow' => $doYouFollow,
            'created_at'=>$this->created_at->format('d-M-y H:i:s')
        ];
    }
}
