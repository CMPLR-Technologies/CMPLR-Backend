<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            //TODO: add title
            'content' =>['required','string'],
            'type' => ['required','string',Rule::in(['text', 'photos','quotes','chats','audio','videos'])],
            'state' => ['required','string',Rule::in(['publish', 'private','draft'])],
            'source_content' =>['string']
        ];
    }
}
