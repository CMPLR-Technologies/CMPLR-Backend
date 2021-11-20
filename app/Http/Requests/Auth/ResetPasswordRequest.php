<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{

    /*
    |--------------------------------------------------------------------------
    | ResetPassword Request
    |--------------------------------------------------------------------------|
    | This class handles the ResetPassword request : validate and filtering 
    | the request , and handle a proper error messages
    |
   */

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
            'email' => ['trim', 'lowercase'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'exists:users', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)
                                                            ->mixedCase()
                                                            ->letters()
                                                            ->numbers()
                                                            ->symbols()
                                                            ->uncompromised()],
            'password_confirmation' => ['required', 'same:password']
        ];
    }
}
