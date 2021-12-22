<?php

namespace App\Http\Resources;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sender=User::find($this->source_user_id);
        $senderPrimaryBlog=Blog::find($sender->primary_blog_id);
        $senderSettings = $senderPrimaryBlog->settings;

        return [
            'message'=> [
                'id'=>$this->id,
                'type'=>$this->type,
                'title'=>$this->source_title,
                'content'=>$this->content,
                'ask_submit'=>$this->post_ask_submit,
                'created_at'=>$this->created_at,
                'tags'=>$this->tags,
            ],
            
            'sender'=>[
                'avatar'=>$senderSettings->avatar,
                'avatar_shape'=>$senderSettings->avatar_shape,
                'primaryBlogId'=>$senderPrimaryBlog->id,
                'primaryBlogName'=>$senderPrimaryBlog->blog_name,
            ],

            'reciever'=>[
                'blogId'=>$this->blog_id,
                'blogName'=>$this->blog_name,
            ]
        ];
    }
}
