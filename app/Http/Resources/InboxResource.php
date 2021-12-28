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
        $senderPrimaryBlog=$sender==null?null:Blog::find($sender->primary_blog_id);
        $senderSettings = $sender==null?null:$senderPrimaryBlog->settings;

        return [
            'message'=> [
                'id'=>$this->id,
                'type'=>$this->type,
                'content'=>$this->content,
                'ask_submit'=>$this->post_ask_submit,
                'created_at'=>$this->created_at,
                'tags'=>$this->tags,
            ],
            
            'sender'=>[
                'avatar'=>$sender==null?null:$senderSettings->avatar,
                'avatar_shape'=>$sender==null?null:$senderSettings->avatar_shape,
                'primaryBlogId'=>$sender==null?null:$senderPrimaryBlog->id,
                'primaryBlogName'=>$sender==null?null:$senderPrimaryBlog->blog_name,
            ],

            'reciever'=>[
                'blogId'=>$this->blog_id,
                'blogName'=>$this->blog_name,
            ]
        ];
    }
}
