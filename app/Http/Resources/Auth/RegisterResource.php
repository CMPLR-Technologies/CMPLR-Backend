<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /*
    |--------------------------------------------------------------------------
    | Register Resource
    |--------------------------------------------------------------------------|
    | This class handles the json response structure for register response
    |
   */

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $blog_settings = $this->blog->settings;
        return [
                'user'=>[
                    'id'=>$this->user->id,
                    'email'=>$this->user->email,
                    'email_verified_at'=>$this->user->email_verified_at,
                    'age'=>$this->user->age,
                    'default_post_format'=>$this->user->default_post_format,
                    'login_options'=>$this->user->email_activity_check,
                    'TFA'=>$this->user->TFA,
                    'filtered_tags'=>$this->user->filtered_tags,
                    'endless_scrolling'=>$this->user->endless_scrolling,
                    'show_badge'=>$this->user->show_badge,
                    'text_editor'=>$this->user->text_editor,
                    'msg_sound'=>$this->user->msg_sound,
                    'best_stuff_first'=>$this->user->best_stuff_first,
                    'include_followed_tags'=>$this->user->include_followed_tags,
                    'conversational_notification'=>$this->user->conversational_notification,
                    'filtered_content'=>$this->user->filtered_content,
                    'theme'=>$this->user->google_id,
                    'primary_blog_id'=>$this->user->primary_blog_id,
                    'blog_name'=>$this->blog->blog_name,
                    'avatar'=>$blog_settings->avatar,
                    'avatar_shape'=>$blog_settings->avatar_shape,
                ],
                'blog_name' => $this->blog->blog_name,
                'token' => $this->token,
        ];
    }
}
