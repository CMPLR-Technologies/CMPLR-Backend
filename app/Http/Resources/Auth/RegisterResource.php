<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
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
            'meta'=>[
                'status'=>201,
                'msg'=>'successfully created'
            ],
            "response"=>[
                'email' => $this->email,
                'blog_name' => $this->blog_name,
                'age' => $this->age,
                'token' => $this->token,
            ],
        ];
    }
}
