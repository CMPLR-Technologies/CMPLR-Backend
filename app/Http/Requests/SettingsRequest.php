<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
            'login_options' => ['string'],
            'email_activity_check' => ['boolean'],
            'TFA' => ['boolean'],
            'filtered_tags' => ['array'],
            'filtered_content' =>['array'],
            'endless_scrolling' => ['boolean'],
            'show_badge' => ['boolean'],
            'text_editor' => ['string'],
            'msg_sound' => ['boolean'],
            'best_stuff_first' => ['boolean'],
            'include_followed_tags'=>['boolean'],
            'conversational_notification'=>['boolean'],
            
        ];
    }
}
