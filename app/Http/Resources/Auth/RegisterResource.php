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
        return [
                'user'=>$this->user,
                'blog_name' => $this->blog_name,
                'avatar' =>$this->avatar,
                'token' => $this->token,
        ];
    }
}
