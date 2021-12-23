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
                'user'=>$this->user,
                'blog_id' =>$this->blog->id,
                'blog_name' => $this->blog->blog_name,
                'avatar' =>$blog_settings->avatar,
                'avatar_shape' => $blog_settings->avatar_shape,
                'token' => $this->token,
        ];
    }
}
