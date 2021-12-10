<?php

namespace App\Http\Requests\Auth;

use App\Http\Misc\Helpers\Errors;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Misc\Traits\WebServiceResponse;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateRegisterRequest extends FormRequest
{
    /*
    |--------------------------------------------------------------------------
    | Validate Register Request
    |--------------------------------------------------------------------------|
    | This class handles the Validation Registration request : validate and filtering 
    | the request , and handle a proper error messages
    |
   */
    use SanitizesInput, WebServiceResponse;
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
     * @return array
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
            'blog_name' => ['required', 'unique:blogs', 'max:255', 'alpha_dash'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string', Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ];
    }

    /** 
     * 
     * This function overrides the failedValidation in validator class 
     *  to return the desired failed response
     * @return json
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error_response(Errors::ERROR_MSGS_400, $validator->errors()->all(), 422)
        );
    }
}
