<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' =>['required'],
            'type' => ['required','string',Rule::in(['text', 'photos','quotes','chats','audio','videos'])],
            'blog_name' => ['required','string','max:22', 'alpha_dash'],
            'state' => ['required','string',Rule::in(['publish', 'private','draft'])],
            'source_content' =>['string'],
            'tags' => ['array']
        ];
    }
}
