<?php

namespace App\Http\Requests\Auth;

use App\Http\Misc\Traits\WebServiceResponse;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rules\Password;

class ValidateRegisterRequest extends FormRequest
{
    use SanitizesInput,WebServiceResponse;
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
            'blog_name' => ['trim', 'lowercase']
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
            'blog_name' => ['required', 'unique:blogs', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string', Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ];
    }
}
