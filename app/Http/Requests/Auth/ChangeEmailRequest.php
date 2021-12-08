<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangeEmailRequest extends FormRequest
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
     * filtering that apply to the request
     */
    public function filters()
    {
        return [
            'email' => ['trim','lowercase'],
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();
        return [
            // check if email is unique or email of Auth User
            'email' => ['required', 'email','max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required','string'],
        ];
    }
}
