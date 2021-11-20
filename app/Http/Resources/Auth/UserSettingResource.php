<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'account' => [
                'login_options' => $this->login_options,
                'email_activity_check' => $this->email_activity_check,
                'TFA' => $this->TFA,
                'filtered_tags' => $this->filtered_tags,
                'filtering_content' => $this->filtering_content,
            ],
            'notification' => [
                'tumblr_news' => $this->tumblr_news,
                'conversational_notification' => $this->conversational_notification,
            ],
            'dashboard'=>[
                'endless_scrolling' => $this->endless_scrolling,
                'show_badge' => $this->show_badge,
                'text_editor' => $this->text_editor,
                'msg_sound' => $this->msg_sound,
                'best_stuff_first' => $this->best_stuff_first,
                'include_followed_tags' =>$this->include_followed_tags,
            ]

        ];
    }
}
